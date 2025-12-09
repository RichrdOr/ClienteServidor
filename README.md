# Sistema de Gestión de Gimnasio - Arquitectura Cliente-Servidor con MVC

[![CI/CD Pipeline](https://github.com/USERNAME/REPO/actions/workflows/ci-cd.yml/badge.svg)](https://github.com/USERNAME/REPO/actions/workflows/ci-cd.yml)
[![Security Scan](https://github.com/USERNAME/REPO/actions/workflows/security.yml/badge.svg)](https://github.com/USERNAME/REPO/actions/workflows/security.yml)

## 📋 Descripción

Aplicación web PHP que demuestra la arquitectura **Cliente-Servidor** utilizando el patrón **MVC** (Modelo-Vista-Controlador). El sistema permite gestionar miembros, clases y pagos de un gimnasio.

**Incluye pipeline completo de DevSecOps con GitHub Actions** para garantizar calidad de código, seguridad y despliegue automatizado.

## 🏗️ Arquitectura

### Cliente-Servidor

- **CLIENTE**: Navegador web (HTML, CSS, JavaScript)
  - Presenta la interfaz de usuario
  - Captura datos del usuario
  - Envía peticiones HTTP al servidor
  - Recibe y muestra respuestas

- **SERVIDOR**: PHP + PostgreSQL
  - Procesa peticiones HTTP
  - Ejecuta lógica de negocio
  - Accede a la base de datos
  - Genera respuestas HTML

### Patrón MVC

- **Modelo (Models)**: Acceso a datos (base de datos)
- **Vista (Views)**: Presentación (HTML)
- **Controlador (Controllers)**: Lógica de negocio y coordinación

## 📁 Estructura del Proyecto

```
ClienteServidor/
├── config/
│   └── database.php          # Configuración de conexión PostgreSQL
├── models/                    # Modelos - Acceso a datos
│   ├── Member.php
│   ├── Class.php
│   └── Payment.php
├── controllers/               # Controladores - Lógica de negocio
│   ├── MemberController.php
│   ├── ClassController.php
│   └── PaymentController.php
├── views/                     # Vistas - Interfaz de usuario
│   ├── members/
│   ├── classes/
│   ├── payments/
│   └── layouts/
├── public/                    # Punto de entrada público
│   ├── index.php             # Router principal
│   └── assets/
│       ├── css/
│       │   └── style.css
│       └── js/
│           └── main.js
├── database/
│   └── schema.sql            # Script de creación de base de datos
├── GUIA_ESTUDIANTE.md        # Guía paso a paso para estudiantes
└── README.md                 # Este archivo
```

## 🚀 Requisitos Previos

- PHP 7.4 o superior
- PostgreSQL 12 o superior
- Servidor web (Apache/Nginx) o PHP built-in server
- Extensión PDO de PHP habilitada

## 📦 Instalación

### 1. Clonar o descargar el proyecto

```bash
cd ClienteServidor
```

### 2. Configurar la base de datos

Edita `config/database.php` con tus credenciales de PostgreSQL:

```php
private const DB_HOST = 'localhost';
private const DB_NAME = 'gimnasio_db';
private const DB_USER = 'postgres';
private const DB_PASS = 'tu_contraseña';
private const DB_PORT = '5432';
```

### 3. Crear la base de datos

```bash
# Conectar a PostgreSQL
psql -U postgres

# Crear la base de datos
CREATE DATABASE gimnasio_db;

# Salir de psql
\q

# Ejecutar el script SQL
psql -U postgres -d gimnasio_db -f database/schema.sql
```

### 4. Configurar el servidor web

#### Opción A: Usar el script run.sh (Recomendado)

```bash
# Desde la raíz del proyecto
./run.sh
```

El script verifica automáticamente los requisitos e inicia el servidor.

#### Opción B: Servidor PHP built-in (manual)

```bash
cd public
php -S localhost:8000
```

Accede a: `http://localhost:8000/index.php`

#### Opción B: Apache/Nginx (producción)

Configura el DocumentRoot de tu servidor web apuntando a la carpeta `public/`.

**Ejemplo para Apache (.htaccess en public/):**

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

## 🎯 Funcionalidades

### Gestión de Miembros
- Listar todos los miembros
- Crear nuevo miembro
- Editar miembro existente
- Eliminar miembro
- Validación de email único

### Gestión de Clases
- Listar todas las clases
- Crear nueva clase
- Editar clase existente
- Eliminar clase
- Información de horarios e instructores

### Gestión de Pagos
- Listar todos los pagos
- Registrar nuevo pago
- Relación con miembros y tipos de membresía
- Historial de pagos

## 🔄 Flujo de Comunicación Cliente-Servidor

```
1. CLIENTE (Navegador)
   ↓ Envía petición HTTP (GET/POST)
   
2. SERVIDOR (public/index.php - Router)
   ↓ Interpreta URL y delega
   
3. CONTROLADOR (ej: MemberController)
   ↓ Procesa lógica y valida
   
4. MODELO (ej: Member)
   ↓ Ejecuta consultas SQL
   
5. BASE DE DATOS (PostgreSQL)
   ↓ Retorna resultados
   
6. MODELO → CONTROLADOR → VISTA
   ↓ Genera HTML
   
7. SERVIDOR → CLIENTE
   ↓ Envía respuesta HTML
   
8. CLIENTE (Navegador)
   ↓ Renderiza la página
```

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 7.4+
- **Base de Datos**: PostgreSQL
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Patrón**: MVC (Modelo-Vista-Controlador)
- **Arquitectura**: Cliente-Servidor

## 📚 Guía para Estudiantes

Consulta `GUIA_ESTUDIANTE.md` para:
- Explicación detallada de la arquitectura Cliente-Servidor
- Explicación del patrón MVC
- Paso a paso para agregar nueva funcionalidad (ejemplo: Gestión de Instructores)
- Código completo para cada paso
- Ejercicios prácticos

## 🔒 DevSecOps

El proyecto incluye un pipeline completo de DevSecOps con GitHub Actions:

- ✅ **Análisis de código**: PHP_CodeSniffer y PHPStan
- ✅ **Análisis de seguridad**: Búsqueda de vulnerabilidades y secretos
- ✅ **Pruebas de base de datos**: Validación automática del schema
- ✅ **Build automatizado**: Validación y generación de reportes
- ✅ **Deploy**: Pipeline de despliegue automatizado

Consulta `DEVSECOPS.md` para más detalles sobre el pipeline CI/CD.

## 🔒 Seguridad

- **Prepared Statements**: Previene SQL injection
- **Validación en Servidor**: Siempre validar datos en el servidor
- **Sanitización**: Uso de `htmlspecialchars()` para prevenir XSS
- **Validación de Email**: Verificación de formato y unicidad

## 📝 Notas de Desarrollo

- El código está comentado para facilitar el aprendizaje
- Los comentarios indican claramente qué parte es CLIENTE y qué parte es SERVIDOR
- Se sigue el patrón MVC estricto
- La validación se realiza tanto en cliente (UX) como en servidor (seguridad)

## 🐛 Solución de Problemas

### Error de conexión a la base de datos
- Verifica que PostgreSQL esté ejecutándose
- Confirma las credenciales en `config/database.php`
- Asegúrate de que la base de datos `gimnasio_db` exista

### Página en blanco
- Verifica los logs de PHP
- Asegúrate de que todas las rutas sean correctas
- Verifica permisos de archivos

### Estilos no se cargan
- Verifica que la ruta `/assets/css/style.css` sea accesible
- Confirma la configuración del servidor web

## 📄 Licencia

Este proyecto es educativo y está diseñado para fines de enseñanza.

## 👥 Autor

Sistema desarrollado para demostrar arquitectura Cliente-Servidor y patrón MVC.

---

**Para más información, consulta `GUIA_ESTUDIANTE.md`**

