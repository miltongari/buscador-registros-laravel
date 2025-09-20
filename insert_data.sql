-- Limpiar datos existentes (opcional, ten cuidado)
-- TRUNCATE TABLE empresa_actividad CASCADE;
-- TRUNCATE TABLE empresas CASCADE;
-- TRUNCATE TABLE actividades CASCADE;

-- Insertar actividades
INSERT INTO actividades (nombre, descripcion, created_at, updated_at) VALUES
('Tecnología', 'Empresas de desarrollo de software y TI', NOW(), NOW()),
('Comercio', 'Venta de productos al por mayor y menor', NOW(), NOW()),
('Manufactura', 'Fabricación de productos industriales', NOW(), NOW()),
('Servicios', 'Prestación de servicios profesionales', NOW(), NOW()),
('Salud', 'Clínicas, hospitales y servicios médicos', NOW(), NOW()),
('Educación', 'Instituciones educativas y capacitación', NOW(), NOW()),
('Construcción', 'Empresas constructoras e inmobiliarias', NOW(), NOW()),
('Transporte', 'Servicios de logística y transporte', NOW(), NOW()),
('Alimentos', 'Restaurantes y producción de alimentos', NOW(), NOW()),
('Finanzas', 'Bancos, seguros y servicios financieros', NOW(), NOW());

-- Insertar empresas
INSERT INTO empresas (nombre, direccion, telefono, email, created_at, updated_at) VALUES
('TechSolutions SA', 'Av. Tecnológica 123', '+123456789', 'info@techsolutions.com', NOW(), NOW()),
('Comercial Norte', 'Calle Comercio 456', '+987654321', 'ventas@comercialnorte.com', NOW(), NOW()),
('Industrias Modernas', 'Zona Industrial 789', '+112233445', 'produccion@industriasmodernas.com', NOW(), NOW()),
('Servicios Profesionales', 'Av. Central 101', '+556677889', 'contacto@serviciospro.com', NOW(), NOW()),
('Clínica Salud Total', 'Av. Médica 202', '+998877665', 'citas@saludtotal.com', NOW(), NOW()),
('Instituto Educativo', 'Calle Conocimiento 303', '+443322110', 'admisiones@institutoedu.com', NOW(), NOW()),
('Constructora Nacional', 'Av. Obra 404', '+667788990', 'proyectos@constructoranacional.com', NOW(), NOW()),
('Transportes Rápidos', 'Calle Logística 505', '+334455667', 'envios@transportesrapidos.com', NOW(), NOW()),
('Restaurante Sabores', 'Av. Gourmet 606', '+778899001', 'reservas@sabores.com', NOW(), NOW()),
('Banco Confianza', 'Av. Financiera 707', '+990011223', 'clientes@bancoconfianza.com', NOW(), NOW());

-- Relacionar empresas con actividades
INSERT INTO empresa_actividad (empresa_id, actividad_id, created_at, updated_at) VALUES
(1, 1, NOW(), NOW()),
(2, 2, NOW(), NOW()),
(3, 3, NOW(), NOW()),
(4, 4, NOW(), NOW()),
(5, 5, NOW(), NOW()),
(6, 6, NOW(), NOW()),
(7, 7, NOW(), NOW()),
(8, 8, NOW(), NOW()),
(9, 9, NOW(), NOW()),
(10, 10, NOW(), NOW()),
(1, 4, NOW(), NOW()),
(4, 1, NOW(), NOW()),
(10, 4, NOW(), NOW());

-- Insertar usuarios
INSERT INTO users (name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
('Administrador', 'admin@buscador.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW()),
('Usuario Demo', 'demo@buscador.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW());