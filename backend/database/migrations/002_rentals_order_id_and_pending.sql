-- Migration 002: Add order_id column to rentals + 'pending' to rental_status enum
-- Run this on existing Supabase projects that already have the schema applied.

begin;

-- 1. Add 'pending' to rental_status enum if not already present
do $$
begin
    alter type public.rental_status add value if not exists 'pending';
exception
    when duplicate_object then null;
end;
$$;

-- 2. Add order_id column to rentals table
alter table public.rentals add column if not exists order_id uuid references public.orders(id) on delete set null;

-- 3. Add index on order_id
create index if not exists idx_rentals_order on public.rentals (order_id);

commit;
