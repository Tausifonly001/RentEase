-- Shiprocket Integration Schema

CREATE TABLE IF NOT EXISTS shiprocket_auth_tokens (
    id SERIAL PRIMARY KEY,
    token TEXT NOT NULL,
    expires_at TIMESTAMP NOT NULL
);

CREATE TABLE IF NOT EXISTS order_shipments (
    id SERIAL PRIMARY KEY,
    order_id INT NOT NULL,
    shiprocket_order_id VARCHAR(50) UNIQUE,
    shiprocket_shipment_id VARCHAR(50) UNIQUE,
    awb_code VARCHAR(50) NULL,
    courier_company_id VARCHAR(50) NULL,
    courier_name VARCHAR(100) NULL,
    status VARCHAR(50) DEFAULT 'NEW',
    status_code VARCHAR(20) NULL,
    label_url TEXT NULL,
    tracking_url TEXT NULL,
    idempotency_key VARCHAR(100) UNIQUE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE INDEX idx_os_status ON order_shipments(status);
CREATE INDEX idx_os_awb_code ON order_shipments(awb_code);
