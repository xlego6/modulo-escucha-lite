# Modulo Escucha Lite

Sistema ligero de gestion de testimonios basado en https://github.com/olimaz/modulo-escucha

## Requisitos

- Docker
- Docker Compose
- Python 3.9+ para los servicios NER y Transcripción

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


## Otros pendientes:



Pendientes 10/12/2025
Chequear que detalles de la entrevista muestre los cambios – Perma, no borrar
Chequear que la buscadora busque los campos con los cambios. -Perma, no borrar
Falta Módulo “Ayuda”                   
Falta Módulo “Revisión de entrevistas” . Quiero hacer un módulo de control de calidad integrado con procesamiento.
Revisar módulo de procesamiento.
Transcripión. Dice que lotes no funciona.
Chequear el tema de NER, Python y los servicios.
Traza  de actividad – Revisar que haga la traza de todo y apunte a los códigos.
Mapa. Carga el mapa, pero no los puntos. Además, la sección “Entrevistas por departamento” se queda “cargando”. Vamos a hacer uno para ver lugares de toma, y otro para ver lugares en el contenido.
Queda pendiente la implementación de usuarios completa
Autenticación y usuarios – FALTA LDAP Y GOOGLE
Dashboard/Estadísticas - FALTA QUÉ ESTADÍSTICAS
Permisos de acceso –  FALTA PERFILES
Revisar códigos dependientes de dependencia.
Al “Editar Entrevista” no guarda lo seleccionado en “Equipo/Estrategia”, tampoco las “Áreas compatibles con el Testimonio”
