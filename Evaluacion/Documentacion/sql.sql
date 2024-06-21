

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    apellido VARCHAR(150) NOT NULL,
    celular VARCHAR(15),
    correo_electronico VARCHAR(150) UNIQUE NOT NULL
);


CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_1 VARCHAR(50) NOT NULL,
    nombre_2 VARCHAR(50),
    apellido_1 VARCHAR(50) NOT NULL,
    apellido_2 VARCHAR(50),
    correo_electronico VARCHAR(150) UNIQUE NOT NULL,
    imagen_perfil VARCHAR(255),
    rol ENUM('administrador', 'usuario_normal') NOT NULL,
    celular VARCHAR(20),
    telefono VARCHAR(20),
    contraseña VARCHAR(255) NOT NULL
);
CREATE TABLE calendarios (
    id_calendario INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    date_from DATE NOT NULL,
    date_to DATE NOT NULL,
    selected_days VARCHAR(255) NOT NULL,
    custom_days_to_remove TEXT,
    slots_config JSON,
    nombre VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);


CREATE TABLE cartas_presentacion (
    id_carta_presentacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    profesion VARCHAR(100),
    descripcion TEXT,
    facebook VARCHAR(255),
    twitter VARCHAR(255),
    instagram VARCHAR(255),
    linkedin VARCHAR(255),
    direccion VARCHAR(255),
    visibilidad ENUM('ocultar', 'visible') DEFAULT 'ocultar', -- Agrega la columna de visibilidad
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);


CREATE TABLE fechas_horarios_disponibles (
    id_fecha_hora_disponible INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    cantidad_reservas_permitidas INT NOT NULL
);


CREATE TABLE permisos (
    id_permiso INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario_dueño INT,
    id_usuario_permiso INT,
    tipo_permiso ENUM('editar', 'agregar', 'eliminar_citas') NOT NULL,
    informacion_relevante TEXT,
    FOREIGN KEY (id_usuario_dueño) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_usuario_permiso) REFERENCES usuarios(id_usuario)
);


CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    estado_pago ENUM('pagado', 'pendiente') NOT NULL,
    comentarios TEXT,
    -- otros campos relevantes para la reserva
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);



CREATE TABLE datos_adicionales_tipos (
    id_dato_adicional_tipo INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario_normal INT,
    nombre_dato VARCHAR(100) NOT NULL,
    tipo_dato ENUM('texto', 'número', 'fecha') NOT NULL,
    obligatorio BOOLEAN NOT NULL,
    FOREIGN KEY (id_usuario_normal) REFERENCES usuarios(id_usuario)
);

CREATE TABLE datos_adicionales (
    id_dato_adicional INT AUTO_INCREMENT PRIMARY KEY,
    id_dato_adicional_tipo INT,
    id_cliente INT,
    valor TEXT,
    FOREIGN KEY (id_dato_adicional_tipo) REFERENCES datos_adicionales_tipos(id_dato_adicional_tipo),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);
CREATE TABLE horarios (
    id_horario INT AUTO_INCREMENT PRIMARY KEY,
    id_fecha_hora_disponible INT,
    id_usuario_normal INT,
    id_reserva INT,
    estado ENUM('disponible', 'reservado') NOT NULL,
    duracion INT NOT NULL,
    FOREIGN KEY (id_fecha_hora_disponible) REFERENCES fechas_horarios_disponibles(id_fecha_hora_disponible),
    FOREIGN KEY (id_usuario_normal) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva)
);
