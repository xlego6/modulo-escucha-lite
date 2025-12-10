# Modulo Escucha Lite

Sistema ligero de gestion de testimonios basado en https://github.com/olimaz/modulo-escucha

## Requisitos

- Docker
- Docker Compose
- Python 9+ para los servicios NER y Transcripción

## Instalacion Rapida

1. **Levantar los contenedores:**

```bash
cd modulo-escucha-lite
docker-compose up -d
```

2. **Generar APP_KEY (primera vez):**

```bash
docker exec -it mel-app php artisan key:generate
```

3. **Acceder a la aplicacion:**

- URL: http://localhost:8001
- Usuario: admin@testimonios.local
- Clave: password

## Estructura

```
modulo-escucha-lite/
├── docker-compose.yml      # Configuracion Docker
├── .docker/                # Dockerfile y configs
├── database/
│   └── init.sql           # Script SQL inicial
└── www/                   # Aplicacion Laravel
    ├── app/
    │   ├── Http/Controllers/
    │   └── Models/        # Modelos simplificados
    ├── config/
    ├── routes/
    └── resources/views/
```

## Servicios Docker

| Servicio | Puerto | Descripcion |
|----------|--------|-------------|
| mel-web  | 8001   | Nginx       |
| mel-app  | -      | PHP-FPM 7.4 |
| mel-db   | 5556   | PostgreSQL  |

## Base de Datos

- Host: mel-db (interno) / localhost:5556 (externo)
- Database: testimonios
- Usuario: dba

### Esquemas

- `esclarecimiento` - Entrevistas, entrevistadores
- `fichas` - Personas, consentimientos
- `catalogos` - Catalogos, geografia

## Comandos Utiles

```bash
# Ver logs
docker-compose logs -f

# Entrar al contenedor PHP
docker exec -it mel-app bash

# Ejecutar artisan
docker exec -it mel-app php artisan [comando]

# Reiniciar BD (elimina datos)
docker-compose down -v
rm -rf postgres-data
docker-compose up -d
```

## Desarrollo

Para adaptar funcionalidades del modulo original:

1. Revisar codigo en `../modulo-de-captura/` o `../www/`
2. Copiar y simplificar controladores/modelos necesarios
3. Adaptar vistas Blade

## Modulos avanzados

- [ ] Login OK, sin LDAP o Google por ahora
- [ ] Entrevistas OK, añadir campos adicionales
- [ ] Personas OK
- [ ] Gestion de Adjuntos OK
- [ ] Buscador OK
- [ ] Exportacion Excel OK
- [ ] Traza de actividad OK, revisar bugs
- [ ] Catálogos OK

## Modulos Pendientes

- [ ] Estadisticas - Funcionalidad básica OK, pendiente revisar métricas e indicadores específicos
- [ ] Gestion de Usuarios - Funcionalidad básica, pendiente gestión de perfiles
- [ ] Permisos - OK para brindar acceso. Pendiente gestión de perfiles
- [ ] Módulo procesamiento - Pendiente, servicios suben, pero no funciona aún
- [ ] Mapa - No aparecen puntos aún. Resolver problema con municipios
