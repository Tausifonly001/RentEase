-- RentEase production schema for Supabase Postgres
-- Execute in Supabase SQL editor as a privileged role.

begin;

create extension if not exists btree_gist;

DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'rental_status') THEN
        CREATE TYPE public.rental_status AS ENUM ('active', 'pending', 'completed', 'cancelled', 'return_requested', 'return_inspection', 'closed');
    ELSE
        -- Add new values if type exists
        BEGIN ALTER TYPE public.rental_status ADD VALUE IF NOT EXISTS 'pending'; EXCEPTION WHEN duplicate_object THEN END;
        BEGIN ALTER TYPE public.rental_status ADD VALUE IF NOT EXISTS 'return_requested'; EXCEPTION WHEN duplicate_object THEN END;
        BEGIN ALTER TYPE public.rental_status ADD VALUE IF NOT EXISTS 'return_inspection'; EXCEPTION WHEN duplicate_object THEN END;
        BEGIN ALTER TYPE public.rental_status ADD VALUE IF NOT EXISTS 'closed'; EXCEPTION WHEN duplicate_object THEN END;
    END IF;
END $$;

DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'user_role') THEN
        CREATE TYPE public.user_role AS ENUM ('user', 'admin', 'vendor');
    ELSE
        BEGIN ALTER TYPE public.user_role ADD VALUE IF NOT EXISTS 'vendor'; EXCEPTION WHEN duplicate_object THEN END;
    END IF;
END $$;

create table if not exists public.profiles (
  id uuid primary key references auth.users(id) on delete cascade,
  email text not null unique,
  full_name text,
  business_name text,
  role public.user_role not null default 'user',
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now()
);

-- Ensure role column exists if table was created without it
alter table public.profiles add column if not exists role public.user_role not null default 'user';

create table if not exists public.products (
  id bigserial primary key,
  vendor_id uuid references public.profiles(id) on delete restrict,
  name text not null check (char_length(trim(name)) >= 2),
  category text not null check (char_length(trim(category)) >= 2),
  monthly_price numeric(12,2) not null check (monthly_price > 0),
  total_stock integer not null check (total_stock >= 0),
  image_url text,
  description text,
  vendor_status text not null default 'active' check (vendor_status in ('active', 'paused', 'archived')),
  created_at timestamptz not null default now()
);

-- Ensure columns exist if table was created without them
alter table public.products add column if not exists vendor_id uuid references public.profiles(id) on delete restrict;
alter table public.products add column if not exists vendor_status text not null default 'active' check (vendor_status in ('active', 'paused', 'archived'));

create index if not exists idx_products_vendor on public.products (vendor_id);

create table if not exists public.rentals (
  id bigserial primary key,
  user_id uuid not null references public.profiles(id) on delete restrict,
  product_id bigint not null references public.products(id) on delete restrict,
  start_date date not null,
  end_date date not null,
  original_end_date date,
  requested_return_date date,
  actual_return_date date,
  extension_count integer default 0,
  last_extended_at timestamptz,
  inspection_notes text,
  damage_assessment numeric(10,2) default 0.00,
  status public.rental_status not null default 'active',
  created_at timestamptz not null default now(),
  constraint rentals_date_order check (end_date >= start_date)
);

create table if not exists public.rental_extensions (
  id bigserial primary key,
  rental_id bigint not null references public.rentals(id) on delete cascade,
  user_id uuid not null references public.profiles(id) on delete cascade,
  extension_days int not null check (extension_days > 0),
  new_end_date date not null,
  created_at timestamptz not null default now()
);

create index if not exists idx_rental_extensions_rental on public.rental_extensions (rental_id);
create index if not exists idx_rental_extensions_user on public.rental_extensions (user_id);

alter table public.rental_extensions enable row level security;

create index if not exists idx_rentals_product_dates on public.rentals (product_id, start_date, end_date);
create index if not exists idx_rentals_user on public.rentals (user_id);
create index if not exists idx_rentals_status on public.rentals (status);

-- Maintenance Requests
DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'maintenance_status') THEN
        CREATE TYPE public.maintenance_status AS ENUM ('OPEN', 'ASSIGNED', 'IN_PROGRESS', 'RESOLVED', 'CLOSED');
    END IF;
END $$;

create table if not exists public.maintenance_requests (
  id bigserial primary key,
  rental_id bigint not null references public.rentals(id) on delete cascade,
  user_id uuid not null references public.profiles(id) on delete cascade,
  issue_description text not null check (char_length(trim(issue_description)) >= 5),
  status public.maintenance_status not null default 'OPEN',
  notes text,
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now(),
  resolved_at timestamptz
);

create index if not exists idx_maintenance_rental on public.maintenance_requests (rental_id);
create index if not exists idx_maintenance_user on public.maintenance_requests (user_id);
create index if not exists idx_maintenance_status on public.maintenance_requests (status);

-- Optional overlap protection for stock=1 products. Multi-stock is enforced in create_rental_booking.
create table if not exists public.single_stock_lock (
  product_id bigint primary key references public.products(id) on delete cascade
);

alter table public.products enable row level security;
alter table public.rentals enable row level security;
alter table public.profiles enable row level security;
alter table public.single_stock_lock enable row level security;
alter table public.maintenance_requests enable row level security;

-- Product visibility can be public for catalog usage.
drop policy if exists products_select_public on public.products;
create policy products_select_public on public.products
for select
using (true);

drop policy if exists products_insert_vendor on public.products;
create policy products_insert_vendor on public.products
for insert
to authenticated
with check (auth.uid() = vendor_id);

drop policy if exists products_update_vendor on public.products;
create policy products_update_vendor on public.products
for update
to authenticated
using (auth.uid() = vendor_id)
with check (auth.uid() = vendor_id);

drop policy if exists products_delete_vendor on public.products;
create policy products_delete_vendor on public.products
for delete
to authenticated
using (auth.uid() = vendor_id);

drop policy if exists profiles_select_own on public.profiles;
create policy profiles_select_own on public.profiles
for select
to authenticated
using (auth.uid() = id);

drop policy if exists profiles_update_own on public.profiles;
create policy profiles_update_own on public.profiles
for update
to authenticated
using (auth.uid() = id)
with check (auth.uid() = id);

drop policy if exists rentals_select_own on public.rentals;
create policy rentals_select_own on public.rentals
for select
to authenticated
using (auth.uid() = user_id);

drop policy if exists rentals_insert_own on public.rentals;
create policy rentals_insert_own on public.rentals
for insert
to authenticated
with check (auth.uid() = user_id);

drop policy if exists rentals_update_own on public.rentals;
create policy rentals_update_own on public.rentals
for update
to authenticated
using (auth.uid() = user_id)
with check (auth.uid() = user_id);

drop policy if exists extensions_select_own on public.rental_extensions;
create policy extensions_select_own on public.rental_extensions
for select to authenticated using (auth.uid() = user_id);

drop policy if exists extensions_insert_own on public.rental_extensions;
create policy extensions_insert_own on public.rental_extensions
for insert to authenticated with check (auth.uid() = user_id);

drop policy if exists maintenance_select_own on public.maintenance_requests;
create policy maintenance_select_own on public.maintenance_requests
for select
to authenticated
using (auth.uid() = user_id);

drop policy if exists maintenance_insert_own on public.maintenance_requests;
create policy maintenance_insert_own on public.maintenance_requests
for insert
to authenticated
with check (auth.uid() = user_id);

drop policy if exists maintenance_update_own on public.maintenance_requests;
create policy maintenance_update_own on public.maintenance_requests
for update
to authenticated
using (auth.uid() = user_id)
with check (auth.uid() = user_id);

drop policy if exists single_stock_lock_none on public.single_stock_lock;
create policy single_stock_lock_none on public.single_stock_lock
for all
to authenticated
using (false)
with check (false);

create or replace function public.handle_new_user()
returns trigger
language plpgsql
security definer
set search_path = public
as $$
begin
  insert into public.profiles (id, email, full_name)
  values (
    new.id,
    coalesce(new.email, ''),
    coalesce(new.raw_user_meta_data ->> 'full_name', '')
  )
  on conflict (id) do update
  set
    email = excluded.email,
    full_name = excluded.full_name,
    updated_at = now();

  return new;
end;
$$;

drop trigger if exists on_auth_user_created on auth.users;
create trigger on_auth_user_created
after insert on auth.users
for each row execute procedure public.handle_new_user();

create or replace function public.get_available_stock(
  p_product_id bigint,
  p_start_date date,
  p_end_date date
)
returns integer
language plpgsql
security invoker
set search_path = public
as $$
declare
  v_total_stock integer;
  v_reserved integer;
begin
  if p_start_date > p_end_date then
    raise exception 'INVALID_DATE_RANGE' using errcode = '22007';
  end if;

  select total_stock into v_total_stock
  from public.products
  where id = p_product_id;

  if v_total_stock is null then
    raise exception 'PRODUCT_NOT_FOUND' using errcode = 'P0002';
  end if;

  select count(*)::integer into v_reserved
  from public.rentals r
  where r.product_id = p_product_id
    and r.status = 'active'
    and daterange(r.start_date, r.end_date, '[]') && daterange(p_start_date, p_end_date, '[]');

  return greatest(v_total_stock - v_reserved, 0);
end;
$$;

create or replace function public.create_rental_booking(
  p_user_id uuid,
  p_product_id bigint,
  p_start_date date,
  p_end_date date
)
returns public.rentals
language plpgsql
security invoker
set search_path = public
as $$
declare
  v_available integer;
  v_row public.rentals;
begin
  if auth.uid() is null or auth.uid() <> p_user_id then
    raise exception 'FORBIDDEN' using errcode = '42501';
  end if;

  if p_start_date > p_end_date then
    raise exception 'INVALID_DATE_RANGE' using errcode = '22007';
  end if;

  perform 1
  from public.products
  where id = p_product_id
  for update;

  if not found then
    raise exception 'PRODUCT_NOT_FOUND' using errcode = 'P0002';
  end if;

  v_available := public.get_available_stock(p_product_id, p_start_date, p_end_date);

  if v_available < 1 then
    raise exception 'UNAVAILABLE_PRODUCT' using errcode = 'P0001';
  end if;

  insert into public.rentals (user_id, product_id, start_date, end_date, status)
  values (p_user_id, p_product_id, p_start_date, p_end_date, 'active')
  returning * into v_row;

  return v_row;
end;
$$;

revoke all on function public.create_rental_booking(uuid, bigint, date, date) from public;
revoke all on function public.get_available_stock(bigint, date, date) from public;
grant execute on function public.create_rental_booking(uuid, bigint, date, date) to authenticated;
grant execute on function public.get_available_stock(bigint, date, date) to authenticated, anon;

-- Payments and orders tables
create table if not exists public.orders (
  id uuid primary key default gen_random_uuid(),
  user_id uuid not null references public.profiles(id) on delete cascade,
  stripe_session_id text unique,
  total_amount numeric(10,2) not null,
  payment_status text not null,
  items jsonb default '[]'::jsonb,
  shipping_status text default 'pending',
  shipment_id text,
  tracking_url text,
  return_status text default 'none',
  created_at timestamptz not null default now()
);

-- Ensure order_id column exists on rentals (after orders table is created)
alter table public.rentals add column if not exists order_id uuid references public.orders(id) on delete set null;
create index if not exists idx_rentals_order on public.rentals (order_id);

create table if not exists public.payments (
  id uuid primary key default gen_random_uuid(),
  user_id uuid not null references public.profiles(id) on delete cascade,
  rental_id bigint references public.rentals(id) on delete set null,
  order_id uuid references public.orders(id) on delete cascade,
  stripe_payment_intent text,
  amount numeric(10,2) not null,
  deposit_amount numeric(10,2) default 0.00,
  deposit_status text default 'held' check (deposit_status in ('held', 'partial_deduction', 'refunded', 'forfeited')),
  damage_deduction numeric(10,2) default 0.00,
  status text not null,
  created_at timestamptz not null default now()
);

alter table public.orders enable row level security;
alter table public.payments enable row level security;

drop policy if exists orders_select_own on public.orders;
create policy orders_select_own on public.orders for select to authenticated using (auth.uid() = user_id);

drop policy if exists orders_insert_own on public.orders;
create policy orders_insert_own on public.orders for insert to authenticated with check (auth.uid() = user_id);

drop policy if exists orders_update_own on public.orders;
create policy orders_update_own on public.orders for update to authenticated using (auth.uid() = user_id) with check (auth.uid() = user_id);

drop policy if exists payments_select_own on public.payments;
create policy payments_select_own on public.payments for select to authenticated using (auth.uid() = user_id);

drop policy if exists payments_insert_own on public.payments;
create policy payments_insert_own on public.payments for insert to authenticated with check (auth.uid() = user_id);

drop policy if exists payments_update_own on public.payments;
create policy payments_update_own on public.payments for update to authenticated using (auth.uid() = user_id) with check (auth.uid() = user_id);

DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'delivery_type') THEN
        CREATE TYPE public.delivery_type AS ENUM ('DELIVERY', 'PICKUP');
    END IF;
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'delivery_status') THEN
        CREATE TYPE public.delivery_status AS ENUM ('SCHEDULED', 'IN_TRANSIT', 'COMPLETED', 'FAILED');
    END IF;
END $$;

create table if not exists public.deliveries (
  id bigserial primary key,
  order_id uuid references public.orders(id) on delete cascade,
  rental_id bigint references public.rentals(id) on delete cascade,
  user_id uuid not null references public.profiles(id) on delete cascade,
  type public.delivery_type not null default 'DELIVERY',
  scheduled_date date not null,
  time_slot text not null,
  address text not null,
  status public.delivery_status not null default 'SCHEDULED',
  agent_notes text,
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now()
);

alter table public.deliveries enable row level security;

drop policy if exists deliveries_select_own on public.deliveries;
create policy deliveries_select_own on public.deliveries for select to authenticated using (auth.uid() = user_id);

-- Only admins/service-role can create/update deliveries
drop policy if exists deliveries_insert_service on public.deliveries;
create policy deliveries_insert_service on public.deliveries
    for insert to authenticated
    with check (auth.role() = 'service_role');

drop policy if exists deliveries_update_service on public.deliveries;
create policy deliveries_update_service on public.deliveries
    for update to authenticated
    using (auth.role() = 'service_role')
    with check (auth.role() = 'service_role');


-- Wishlists
create table if not exists public.wishlists (
  id bigserial primary key,
  user_id uuid not null references public.profiles(id) on delete cascade,
  product_id bigint not null references public.products(id) on delete cascade,
  created_at timestamptz not null default now(),
  unique(user_id, product_id)
);

alter table public.wishlists enable row level security;
drop policy if exists wishlists_select_own on public.wishlists;
create policy wishlists_select_own on public.wishlists for select to authenticated using (auth.uid() = user_id);
drop policy if exists wishlists_insert_own on public.wishlists;
create policy wishlists_insert_own on public.wishlists for insert to authenticated with check (auth.uid() = user_id);
drop policy if exists wishlists_delete_own on public.wishlists;
create policy wishlists_delete_own on public.wishlists for delete to authenticated using (auth.uid() = user_id);

-- Referrals
create table if not exists public.referrals (
  id bigserial primary key,
  referrer_id uuid not null references public.profiles(id) on delete cascade,
  referred_email text not null,
  status text not null default 'pending',
  reward_earned numeric(10,2) default 0.00,
  created_at timestamptz not null default now()
);

create table if not exists public.referral_stats (
  user_id uuid primary key references public.profiles(id) on delete cascade,
  total_earned numeric(10,2) default 0.00,
  friends_invited integer default 0,
  successful_referrals integer default 0,
  pending_invitations integer default 0,
  referral_code text unique
);

alter table public.referrals enable row level security;
alter table public.referral_stats enable row level security;

drop policy if exists referrals_select_own on public.referrals;
create policy referrals_select_own on public.referrals for select to authenticated using (auth.uid() = referrer_id);
drop policy if exists referral_stats_select_own on public.referral_stats;
create policy referral_stats_select_own on public.referral_stats for select to authenticated using (auth.uid() = user_id);

-- Rewards
create table if not exists public.user_rewards (
  user_id uuid primary key references public.profiles(id) on delete cascade,
  points_balance integer default 0,
  tier text default 'Bronze',
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now()
);

create table if not exists public.rewards_catalog (
  id bigserial primary key,
  name text not null,
  description text,
  points_required integer not null,
  category text,
  image_url text,
  active boolean default true
);

create table if not exists public.reward_redemptions (
  id bigserial primary key,
  user_id uuid not null references public.profiles(id) on delete cascade,
  reward_id bigint not null references public.rewards_catalog(id),
  points_spent integer not null,
  status text default 'pending',
  created_at timestamptz not null default now()
);

alter table public.user_rewards enable row level security;
alter table public.rewards_catalog enable row level security;
alter table public.reward_redemptions enable row level security;

drop policy if exists user_rewards_select_own on public.user_rewards;
create policy user_rewards_select_own on public.user_rewards for select to authenticated using (auth.uid() = user_id);
drop policy if exists rewards_catalog_select_all on public.rewards_catalog;
create policy rewards_catalog_select_all on public.rewards_catalog for select using (active = true);
drop policy if exists redemptions_select_own on public.reward_redemptions;
create policy redemptions_select_own on public.reward_redemptions for select to authenticated using (auth.uid() = user_id);

-- Support Tickets
create table if not exists public.support_tickets (
  id bigserial primary key,
  user_id uuid not null references public.profiles(id) on delete cascade,
  subject text not null,
  message text not null,
  status text default 'open',
  priority text default 'normal',
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now()
);

alter table public.support_tickets enable row level security;
drop policy if exists tickets_select_own on public.support_tickets;
create policy tickets_select_own on public.support_tickets for select to authenticated using (auth.uid() = user_id);
drop policy if exists tickets_insert_own on public.support_tickets;
create policy tickets_insert_own on public.support_tickets for insert to authenticated with check (auth.uid() = user_id);

-- Password Resets
create table if not exists public.password_resets (
  id bigserial primary key,
  email text not null,
  token text not null,
  expires_at timestamptz not null,
  created_at timestamptz not null default now()
);

create index if not exists idx_password_resets_email on public.password_resets (email);
create index if not exists idx_password_resets_token on public.password_resets (token);

alter table public.password_resets enable row level security;

-- Only service role should manage resets
drop policy if exists password_resets_none on public.password_resets;
create policy password_resets_none on public.password_resets
for all
to authenticated, anon
using (false)
with check (false);

-- ============================================================================
-- SEC-005: Webhook Events table for idempotent processing
-- Prevents duplicate processing of Stripe webhook events on retries.
-- ============================================================================
create table if not exists public.webhook_events (
    id bigint generated by default as identity primary key,
    event_id text not null unique,
    event_type text not null default '',
    processed_at timestamptz not null default now(),
    created_at timestamptz not null default now()
);

create index if not exists idx_webhook_events_event_id on public.webhook_events (event_id);

alter table public.webhook_events enable row level security;

drop policy if exists "Service role full access on webhook_events" on public.webhook_events;
create policy "Service role full access on webhook_events"
    on public.webhook_events
    for all
    using (auth.role() = 'service_role')
    with check (auth.role() = 'service_role');

commit;

