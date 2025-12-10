-- =============================================
-- MODULO ESCUCHA LITE - Script de Inicialización
-- Base de datos: testimonios
-- =============================================

-- Crear extensión UUID
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- =============================================
-- CREAR ESQUEMAS
-- =============================================
CREATE SCHEMA IF NOT EXISTS esclarecimiento;
CREATE SCHEMA IF NOT EXISTS fichas;
CREATE SCHEMA IF NOT EXISTS catalogos;

-- =============================================
-- ESQUEMA: catalogos
-- =============================================

-- Tabla de catálogos maestros
CREATE TABLE catalogos.cat_cat (
    id_cat SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    editable INTEGER DEFAULT 1,
    id_reclasificado INTEGER REFERENCES catalogos.cat_cat(id_cat)
);

-- Tabla de items de catálogos
CREATE TABLE catalogos.cat_item (
    id_item SERIAL PRIMARY KEY,
    id_cat INTEGER NOT NULL REFERENCES catalogos.cat_cat(id_cat),
    descripcion VARCHAR(255) NOT NULL,
    abreviado VARCHAR(50),
    texto TEXT,
    orden INTEGER DEFAULT 0,
    predeterminado INTEGER DEFAULT 2,
    otro VARCHAR(255),
    habilitado INTEGER DEFAULT 1,
    pendiente_revisar INTEGER DEFAULT 0,
    id_entrevistador INTEGER,
    id_reclasificado INTEGER REFERENCES catalogos.cat_item(id_item)
);

-- Tabla de geografía (DIVIPOLA)
CREATE TABLE catalogos.geo (
    id_geo SERIAL PRIMARY KEY,
    id_padre INTEGER REFERENCES catalogos.geo(id_geo),
    nivel INTEGER NOT NULL, -- 1=país, 2=depto, 3=municipio
    descripcion VARCHAR(255) NOT NULL,
    id_tipo INTEGER,
    codigo VARCHAR(20),
    lat DECIMAL(10,7),
    lon DECIMAL(10,7),
    codigo_2 VARCHAR(20)
);

-- Tabla de criterios fijos (para opciones del sistema)
CREATE TABLE catalogos.criterio_fijo (
    id_opcion SERIAL PRIMARY KEY,
    id_grupo INTEGER NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    abreviado VARCHAR(50),
    orden INTEGER DEFAULT 0,
    habilitado INTEGER DEFAULT 1
);

-- =============================================
-- TABLA DE USUARIOS (Laravel estándar)
-- =============================================
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- ESQUEMA: esclarecimiento
-- =============================================

-- Tabla de entrevistadores
CREATE TABLE esclarecimiento.entrevistador (
    id_entrevistador SERIAL PRIMARY KEY,
    id_usuario INTEGER REFERENCES users(id),
    id_macroterritorio INTEGER REFERENCES catalogos.geo(id_geo),
    id_territorio INTEGER REFERENCES catalogos.geo(id_geo),
    numero_entrevistador INTEGER,
    id_ubicacion INTEGER REFERENCES catalogos.geo(id_geo),
    id_grupo INTEGER REFERENCES catalogos.criterio_fijo(id_opcion),
    id_nivel INTEGER REFERENCES catalogos.criterio_fijo(id_opcion),
    solo_lectura INTEGER DEFAULT 0,
    compromiso_reserva INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de entrevistas individuales
CREATE TABLE esclarecimiento.e_ind_fvt (
    id_e_ind_fvt SERIAL PRIMARY KEY,
    id_subserie INTEGER,
    id_entrevistador INTEGER REFERENCES esclarecimiento.entrevistador(id_entrevistador),
    id_macroterritorio INTEGER REFERENCES catalogos.geo(id_geo),
    id_territorio INTEGER REFERENCES catalogos.geo(id_geo),
    entrevista_codigo VARCHAR(50),
    entrevista_numero INTEGER,
    entrevista_correlativo INTEGER,
    entrevista_fecha DATE,
    numero_entrevistador INTEGER,
    hechos_del DATE,
    hechos_al DATE,
    hechos_lugar INTEGER REFERENCES catalogos.geo(id_geo),
    entrevista_lugar INTEGER REFERENCES catalogos.geo(id_geo),
    anotaciones TEXT,
    titulo VARCHAR(500),
    seguimiento_revisado VARCHAR(50),
    seguimiento_finalizado INTEGER DEFAULT 0,
    metadatos_ce JSONB,
    metadatos_ca JSONB,
    metadatos_da JSONB,
    metadatos_ac JSONB,
    nna INTEGER DEFAULT 0,
    tiempo_entrevista INTEGER,
    clasifica_nna INTEGER,
    clasifica_sex INTEGER,
    clasifica_res INTEGER,
    clasifica_nivel INTEGER,
    clasifica_r1 INTEGER DEFAULT 0,
    clasifica_r2 INTEGER DEFAULT 0,
    html_transcripcion TEXT,
    json_etiquetado JSONB,
    fts TEXT,
    id_cerrado INTEGER,
    fichas_alarmas JSONB,
    fichas_estado INTEGER,
    es_virtual INTEGER DEFAULT 0,
    id_transcrita INTEGER,
    id_etiquetada INTEGER,
    id_activo INTEGER DEFAULT 1,
    id_remitido INTEGER,
    id_prioritario INTEGER,
    prioritario_tema TEXT,
    id_sector INTEGER REFERENCES catalogos.cat_item(id_item),
    id_etnico INTEGER REFERENCES catalogos.cat_item(id_item),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    insert_fh TIMESTAMP,
    insert_ip VARCHAR(45),
    insert_ent INTEGER,
    update_fh TIMESTAMP,
    update_ip VARCHAR(45),
    update_ent INTEGER
);

-- Tabla de adjuntos
CREATE TABLE esclarecimiento.adjunto (
    id_adjunto SERIAL PRIMARY KEY,
    id_e_ind_fvt INTEGER REFERENCES esclarecimiento.e_ind_fvt(id_e_ind_fvt),
    ubicacion VARCHAR(500),
    nombre_original VARCHAR(255),
    tipo_mime VARCHAR(100),
    id_tipo INTEGER REFERENCES catalogos.cat_item(id_item),
    id_calificacion INTEGER,
    tamano BIGINT,
    tamano_bruto BIGINT,
    md5 VARCHAR(32),
    liviano_ubicacion VARCHAR(500),
    liviano_tamano BIGINT,
    liviano_md5 VARCHAR(32),
    existe_archivo INTEGER DEFAULT 1,
    duracion INTEGER,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    insert_fh TIMESTAMP,
    insert_ip VARCHAR(45),
    insert_ent INTEGER,
    update_fh TIMESTAMP,
    update_ip VARCHAR(45),
    update_ent INTEGER
);

-- =============================================
-- ESQUEMA: fichas
-- =============================================

-- Tabla de personas
CREATE TABLE fichas.persona (
    id_persona SERIAL PRIMARY KEY,
    nombre VARCHAR(200),
    apellido VARCHAR(200),
    alias VARCHAR(100),
    fec_nac_a INTEGER,
    fec_nac_m INTEGER,
    fec_nac_d INTEGER,
    id_lugar_nacimiento INTEGER REFERENCES catalogos.geo(id_geo),
    id_lugar_nacimiento_depto INTEGER REFERENCES catalogos.geo(id_geo),
    id_sexo INTEGER REFERENCES catalogos.cat_item(id_item),
    id_orientacion INTEGER REFERENCES catalogos.cat_item(id_item),
    id_identidad INTEGER REFERENCES catalogos.cat_item(id_item),
    id_etnia INTEGER REFERENCES catalogos.cat_item(id_item),
    id_etnia_indigena INTEGER REFERENCES catalogos.cat_item(id_item),
    id_tipo_documento INTEGER REFERENCES catalogos.cat_item(id_item),
    num_documento VARCHAR(50),
    id_nacionalidad INTEGER REFERENCES catalogos.cat_item(id_item),
    id_otra_nacionalidad INTEGER REFERENCES catalogos.cat_item(id_item),
    id_estado_civil INTEGER REFERENCES catalogos.cat_item(id_item),
    id_lugar_residencia INTEGER REFERENCES catalogos.geo(id_geo),
    id_lugar_residencia_muni INTEGER REFERENCES catalogos.geo(id_geo),
    id_lugar_residencia_depto INTEGER REFERENCES catalogos.geo(id_geo),
    lugar_residencia_nombre_vereda VARCHAR(200),
    id_zona INTEGER REFERENCES catalogos.cat_item(id_item),
    telefono VARCHAR(50),
    correo_electronico VARCHAR(100),
    id_edu_formal INTEGER REFERENCES catalogos.cat_item(id_item),
    profesion VARCHAR(200),
    ocupacion_actual VARCHAR(200),
    id_ocupacion_actual INTEGER REFERENCES catalogos.cat_item(id_item),
    cargo_publico INTEGER DEFAULT 0,
    cargo_publico_cual VARCHAR(200),
    id_fuerza_publica_estado INTEGER REFERENCES catalogos.cat_item(id_item),
    fuerza_publica_especificar VARCHAR(200),
    id_fuerza_publica INTEGER REFERENCES catalogos.cat_item(id_item),
    id_actor_armado INTEGER REFERENCES catalogos.cat_item(id_item),
    actor_armado_especificar VARCHAR(200),
    organizacion_colectivo INTEGER DEFAULT 0,
    nombre_organizacion VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    insert_fh TIMESTAMP,
    insert_ip VARCHAR(45),
    insert_ent INTEGER,
    update_fh TIMESTAMP,
    update_ip VARCHAR(45),
    update_ent INTEGER
);

-- Tabla de consentimiento/entrevista
CREATE TABLE fichas.entrevista (
    id_entrevista SERIAL PRIMARY KEY,
    id_e_ind_fvt INTEGER REFERENCES esclarecimiento.e_ind_fvt(id_e_ind_fvt),
    id_idioma INTEGER REFERENCES catalogos.cat_item(id_item),
    id_nativo INTEGER REFERENCES catalogos.cat_item(id_item),
    nombre_interprete VARCHAR(200),
    documentacion_aporta INTEGER,
    documentacion_especificar VARCHAR(500),
    identifica_testigos INTEGER,
    ampliar_relato INTEGER,
    ampliar_relato_temas VARCHAR(500),
    priorizar_entrevista INTEGER,
    priorizar_entrevista_asuntos VARCHAR(500),
    contiene_patrones INTEGER,
    contiene_patrones_cuales VARCHAR(500),
    indicaciones_transcripcion VARCHAR(500),
    observaciones TEXT,
    identificacion_consentimiento INTEGER,
    conceder_entrevista INTEGER,
    grabar_audio INTEGER,
    grabar_video INTEGER,
    tomar_fotografia INTEGER,
    elaborar_informe INTEGER,
    tratamiento_datos_analizar INTEGER,
    tratamiento_datos_analizar_sensible INTEGER,
    tratamiento_datos_utilizar INTEGER,
    tratamiento_datos_utilizar_sensible INTEGER,
    tratamiento_datos_publicar INTEGER,
    divulgar_material INTEGER,
    traslado_info INTEGER,
    compartir_info INTEGER,
    nombre_autoridad_etnica VARCHAR(200),
    nombre_identitario VARCHAR(200),
    pueblo_representado VARCHAR(200),
    id_pueblo_representado INTEGER REFERENCES catalogos.cat_item(id_item),
    asistencia INTEGER,
    restrictiva INTEGER,
    borrable INTEGER DEFAULT 0,
    consentimiento_nombres VARCHAR(200),
    consentimiento_apellidos VARCHAR(200),
    consentimiento_sexo INTEGER,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    insert_fh TIMESTAMP,
    insert_ip VARCHAR(45),
    insert_ent INTEGER,
    update_fh TIMESTAMP,
    update_ip VARCHAR(45),
    update_ent INTEGER
);

-- Tabla de persona entrevistada (relación persona-entrevista)
CREATE TABLE fichas.persona_entrevistada (
    id_persona_entrevistada SERIAL PRIMARY KEY,
    id_persona INTEGER REFERENCES fichas.persona(id_persona),
    id_e_ind_fvt INTEGER REFERENCES esclarecimiento.e_ind_fvt(id_e_ind_fvt),
    es_victima INTEGER DEFAULT 0,
    es_testigo INTEGER DEFAULT 0,
    es_familiar INTEGER DEFAULT 0,
    edad INTEGER,
    sintesis_relato TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    insert_fh TIMESTAMP,
    insert_ip VARCHAR(45),
    insert_ent INTEGER,
    update_fh TIMESTAMP,
    update_ip VARCHAR(45),
    update_ent INTEGER
);

-- =============================================
-- TABLA: traza_actividad (auditoría)
-- =============================================
CREATE TABLE traza_actividad (
    id_traza_actividad BIGSERIAL PRIMARY KEY,
    fecha_hora TIMESTAMP(6) DEFAULT CURRENT_TIMESTAMP,
    id_usuario INTEGER REFERENCES users(id),
    accion VARCHAR(100),
    objeto VARCHAR(100),
    id_registro INTEGER,
    referencia VARCHAR(500),
    codigo VARCHAR(100),
    ip VARCHAR(45),
    id_personificador INTEGER REFERENCES users(id)
);

-- =============================================
-- TABLA: permisos
-- =============================================
CREATE TABLE esclarecimiento.permiso (
    id_permiso SERIAL PRIMARY KEY,
    id_entrevistador INTEGER REFERENCES esclarecimiento.entrevistador(id_entrevistador),
    id_e_ind_fvt INTEGER REFERENCES esclarecimiento.e_ind_fvt(id_e_ind_fvt),
    id_tipo INTEGER DEFAULT 1, -- 1=lectura, 2=escritura
    fecha_otorgado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_vencimiento TIMESTAMP,
    justificacion TEXT,
    id_otorgado_por INTEGER REFERENCES esclarecimiento.entrevistador(id_entrevistador),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- ÍNDICES
-- =============================================
CREATE INDEX idx_entrevista_codigo ON esclarecimiento.e_ind_fvt(entrevista_codigo);
CREATE INDEX idx_entrevista_fecha ON esclarecimiento.e_ind_fvt(entrevista_fecha);
CREATE INDEX idx_entrevista_entrevistador ON esclarecimiento.e_ind_fvt(id_entrevistador);
CREATE INDEX idx_entrevista_activo ON esclarecimiento.e_ind_fvt(id_activo);
CREATE INDEX idx_adjunto_entrevista ON esclarecimiento.adjunto(id_e_ind_fvt);
CREATE INDEX idx_persona_nombre ON fichas.persona(nombre, apellido);
CREATE INDEX idx_persona_documento ON fichas.persona(num_documento);
CREATE INDEX idx_cat_item_cat ON catalogos.cat_item(id_cat);
CREATE INDEX idx_geo_padre ON catalogos.geo(id_padre);
CREATE INDEX idx_traza_usuario ON traza_actividad(id_usuario);
CREATE INDEX idx_traza_fecha ON traza_actividad(fecha_hora);

-- =============================================
-- DATOS INICIALES: Criterios fijos (niveles de usuario)
-- =============================================
INSERT INTO catalogos.criterio_fijo (id_opcion, id_grupo, descripcion, abreviado, orden) VALUES
(1, 1, 'Administrador', 'Admin', 1),
(2, 1, 'Esclarecimiento', 'Escl', 2),
(3, 1, 'Supervisor', 'Sup', 3),
(4, 1, 'Coordinador', 'Coord', 4),
(5, 1, 'Entrevistador', 'Ent', 5),
(6, 1, 'Confidencial', 'Conf', 6),
(7, 1, 'Estadísticas', 'Est', 7),
(10, 1, 'Transcriptor', 'Trans', 10),
(11, 1, 'Etiquetador', 'Etiq', 11),
(99, 1, 'Deshabilitado', 'Des', 99);

-- Acciones de auditoría
INSERT INTO catalogos.criterio_fijo (id_opcion, id_grupo, descripcion, abreviado, orden) VALUES
(21, 21, 'Crear', 'C', 1),
(22, 21, 'Leer', 'R', 2),
(23, 21, 'Actualizar', 'U', 3),
(24, 21, 'Eliminar', 'D', 4),
(25, 21, 'Login', 'L', 5),
(26, 21, 'Logout', 'O', 6);

-- Objetos de auditoría
INSERT INTO catalogos.criterio_fijo (id_opcion, id_grupo, descripcion, abreviado, orden) VALUES
(31, 22, 'Entrevista', 'Ent', 1),
(32, 22, 'Persona', 'Per', 2),
(33, 22, 'Adjunto', 'Adj', 3),
(34, 22, 'Usuario', 'Usr', 4),
(35, 22, 'Permiso', 'Prm', 5);

-- =============================================
-- DATOS INICIALES: Catálogos básicos
-- =============================================

-- Catálogo de Sexo
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES
(1, 'Sexo', 'Sexo biológico', 0);

INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, orden) VALUES
(1, 1, 'Hombre', 'H', 1),
(2, 1, 'Mujer', 'M', 2),
(3, 1, 'Intersexual', 'I', 3);

-- Catálogo de Tipo de Documento
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES
(2, 'Tipo de Documento', 'Tipos de documento de identidad', 0);

INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, orden) VALUES
(10, 2, 'Cédula de Ciudadanía', 'CC', 1),
(11, 2, 'Tarjeta de Identidad', 'TI', 2),
(12, 2, 'Cédula de Extranjería', 'CE', 3),
(13, 2, 'Pasaporte', 'PA', 4),
(14, 2, 'Registro Civil', 'RC', 5),
(15, 2, 'Sin Documento', 'SD', 6);

-- Catálogo de Etnia
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES
(3, 'Grupo Étnico', 'Grupos étnicos', 0);

INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, orden) VALUES
(20, 3, 'Comunidades negras', 'CN', 1),
(21, 3, 'Pueblos indígenas', 'PI', 2),
(22, 3, 'Palenqueras', 'PA', 3),
(23, 3, 'Raizales', 'RA', 4),
(24, 3, 'Pueblo Rrom', 'RR', 5),
(25, 3, 'Ningún grupo étnico', 'NG', 6);

-- Catálogo de Dependencia de Origen
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES
(4, 'Dependencia de Origen', 'Áreas que realizaron la toma del testimonio', 0);

INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, orden) VALUES
(30, 4, 'Dirección Museo de Memoria y Conflicto', 'DMMC', 1),
(31, 4, 'Dirección de Construcción de Memoria Histórica', 'DCMH', 2),
(32, 4, 'Dirección de Acuerdos de la Verdad', 'DAV', 3),
(33, 4, 'Dirección de Archivo de los Derechos Humanos', 'DADH', 4),
(34, 4, 'Estrategia de Comunicaciones', 'EC', 5),
(35, 4, 'Dirección General', 'DG', 6),
(36, 4, 'Estrategia de Pedagogía', 'EP', 7),
(37, 4, 'Estrategia de Enfoques Diferenciales', 'EED', 8),
(38, 4, 'Estrategia Psicosocial', 'EPS', 9),
(39, 4, 'Estrategia de Territorialización', 'ET', 10),
(40, 4, 'Testimonio allegado al CNMH', 'TA', 11);

-- Catálogo de Tipo de Testimonio
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES
(5, 'Tipo de Testimonio', 'Clasificación según enfoque del testimonio', 0);

INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, orden) VALUES
(50, 5, 'Entrevista Individual', 'EI', 1),
(51, 5, 'Entrevista grupal/colectiva', 'EG', 2),
(52, 5, 'Entrevista a Profundidad', 'EP', 3),
(53, 5, 'Entrevista Estructurada', 'EE', 4),
(54, 5, 'Entrevista de Ampliación', 'EA', 5);

-- Catálogo de Formato del Testimonio
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES
(6, 'Formato del Testimonio', 'Formato en que fueron producidos los documentos', 0);

INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, orden) VALUES
(60, 6, 'Audio', 'AUD', 1),
(61, 6, 'Audiovisual', 'AV', 2),
(62, 6, 'Escrito', 'ESC', 3),
(63, 6, 'Otra índole', 'OTR', 4);

-- Catálogo de Modalidad
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES
(7, 'Modalidad', 'Forma en que se llevó a cabo la entrevista', 0);

INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, orden) VALUES
(70, 7, 'Virtual', 'VIR', 1),
(71, 7, 'Presencial', 'PRE', 2),
(72, 7, 'Sin Información', 'SI', 3);

-- Catálogo de Idiomas
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES
(8, 'Idioma', 'Idiomas del testimonio', 1);

INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, orden) VALUES
(80, 8, 'Español', 'ES', 1),
(81, 8, 'Inglés', 'EN', 2),
(82, 8, 'Lengua nativa', 'LN', 3);

-- Catálogo de Poblaciones
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES
(9, 'Población', 'Grupos sociales o comunitarios', 1);

INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, orden) VALUES
(90, 9, 'Líderes y/o lideresas', 'LID', 1),
(91, 9, 'Personas refugiadas', 'REF', 2),
(92, 9, 'Personas inmigrantes', 'INM', 3),
(93, 9, 'Personas exiliadas', 'EXI', 4),
(94, 9, 'Habitantes de calle', 'HAB', 5),
(95, 9, 'Personas desmovilizadas', 'DES', 6),
(96, 9, 'Menores desvinculados', 'MEN', 7),
(97, 9, 'Personas privadas de la libertad', 'PPL', 8),
(98, 9, 'Sindicalistas', 'SIN', 9),
(99, 9, 'Víctimas del conflicto armado', 'VIC', 10),
(100, 9, 'Ex miembro de Fuerza Pública', 'EFP', 11);

-- Catálogo de Hechos Victimizantes
INSERT INTO catalogos.cat_cat (id_cat, nombre, descripcion, editable) VALUES
(10, 'Hecho Victimizante', 'Tipos de hechos victimizantes', 0);

INSERT INTO catalogos.cat_item (id_item, id_cat, descripcion, abreviado, orden) VALUES
(110, 10, 'Acciones Bélicas', 'AB', 1),
(111, 10, 'Asesinatos Selectivos', 'AS', 2),
(112, 10, 'Atentado Terrorista', 'AT', 3),
(113, 10, 'Daño a Bienes Civiles', 'DB', 4),
(114, 10, 'Desaparición Forzada', 'DF', 5),
(115, 10, 'Masacres', 'MA', 6),
(116, 10, 'Reclutamiento de Menores', 'RU', 7),
(117, 10, 'Secuestro', 'SE', 8),
(118, 10, 'Violencia Sexual', 'VS', 9),
(119, 10, 'Ataque a Poblado', 'AP', 10),
(120, 10, 'Minas', 'MI', 11),
(121, 10, 'Desplazamiento forzado', 'DF', 12);

-- =============================================
-- DATOS INICIALES: Geografía Colombia (básico)
-- =============================================
INSERT INTO catalogos.geo (id_geo, id_padre, nivel, descripcion, codigo) VALUES
(1, NULL, 1, 'Colombia', 'CO');

-- Departamentos principales
INSERT INTO catalogos.geo (id_geo, id_padre, nivel, descripcion, codigo) VALUES
(5, 1, 2, 'Antioquia', '05'),
(8, 1, 2, 'Atlántico', '08'),
(11, 1, 2, 'Bogotá D.C.', '11'),
(13, 1, 2, 'Bolívar', '13'),
(15, 1, 2, 'Boyacá', '15'),
(17, 1, 2, 'Caldas', '17'),
(18, 1, 2, 'Caquetá', '18'),
(19, 1, 2, 'Cauca', '19'),
(20, 1, 2, 'Cesar', '20'),
(23, 1, 2, 'Córdoba', '23'),
(25, 1, 2, 'Cundinamarca', '25'),
(27, 1, 2, 'Chocó', '27'),
(41, 1, 2, 'Huila', '41'),
(44, 1, 2, 'La Guajira', '44'),
(47, 1, 2, 'Magdalena', '47'),
(50, 1, 2, 'Meta', '50'),
(52, 1, 2, 'Nariño', '52'),
(54, 1, 2, 'Norte de Santander', '54'),
(63, 1, 2, 'Quindío', '63'),
(66, 1, 2, 'Risaralda', '66'),
(68, 1, 2, 'Santander', '68'),
(70, 1, 2, 'Sucre', '70'),
(73, 1, 2, 'Tolima', '73'),
(76, 1, 2, 'Valle del Cauca', '76'),
(81, 1, 2, 'Arauca', '81'),
(85, 1, 2, 'Casanare', '85'),
(86, 1, 2, 'Putumayo', '86'),
(88, 1, 2, 'San Andrés y Providencia', '88'),
(91, 1, 2, 'Amazonas', '91'),
(94, 1, 2, 'Guainía', '94'),
(95, 1, 2, 'Guaviare', '95'),
(97, 1, 2, 'Vaupés', '97'),
(99, 1, 2, 'Vichada', '99');

-- Algunas capitales/municipios principales
INSERT INTO catalogos.geo (id_geo, id_padre, nivel, descripcion, codigo) VALUES
(1001, 5, 3, 'Medellín', '05001'),
(1002, 8, 3, 'Barranquilla', '08001'),
(1003, 11, 3, 'Bogotá D.C.', '11001'),
(1004, 13, 3, 'Cartagena', '13001'),
(1005, 15, 3, 'Tunja', '15001'),
(1006, 17, 3, 'Manizales', '17001'),
(1007, 18, 3, 'Florencia', '18001'),
(1008, 19, 3, 'Popayán', '19001'),
(1009, 20, 3, 'Valledupar', '20001'),
(1010, 23, 3, 'Montería', '23001'),
(1011, 27, 3, 'Quibdó', '27001'),
(1012, 41, 3, 'Neiva', '41001'),
(1013, 44, 3, 'Riohacha', '44001'),
(1014, 47, 3, 'Santa Marta', '47001'),
(1015, 50, 3, 'Villavicencio', '50001'),
(1016, 52, 3, 'Pasto', '52001'),
(1017, 54, 3, 'Cúcuta', '54001'),
(1018, 63, 3, 'Armenia', '63001'),
(1019, 66, 3, 'Pereira', '66001'),
(1020, 68, 3, 'Bucaramanga', '68001'),
(1021, 70, 3, 'Sincelejo', '70001'),
(1022, 73, 3, 'Ibagué', '73001'),
(1023, 76, 3, 'Cali', '76001');

-- =============================================
-- USUARIO ADMINISTRADOR POR DEFECTO
-- Password: admin123 (bcrypt hash)
-- =============================================
INSERT INTO users (id, name, email, password, created_at, updated_at) VALUES
(1, 'Administrador', 'admin@testimonios.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO esclarecimiento.entrevistador (id_entrevistador, id_usuario, id_nivel, solo_lectura, compromiso_reserva) VALUES
(1, 1, 1, 0, 1);

-- Resetear secuencias
SELECT setval('users_id_seq', (SELECT MAX(id) FROM users));
SELECT setval('esclarecimiento.entrevistador_id_entrevistador_seq', (SELECT MAX(id_entrevistador) FROM esclarecimiento.entrevistador));
SELECT setval('catalogos.cat_cat_id_cat_seq', (SELECT MAX(id_cat) FROM catalogos.cat_cat));
SELECT setval('catalogos.cat_item_id_item_seq', (SELECT MAX(id_item) FROM catalogos.cat_item));
SELECT setval('catalogos.geo_id_geo_seq', (SELECT MAX(id_geo) FROM catalogos.geo));
SELECT setval('catalogos.criterio_fijo_id_opcion_seq', (SELECT MAX(id_opcion) FROM catalogos.criterio_fijo));

-- =============================================
-- FIN DEL SCRIPT
-- =============================================
