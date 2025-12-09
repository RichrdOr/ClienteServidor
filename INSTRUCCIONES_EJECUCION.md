# 🚀 Instrucciones para Ejecutar el Programa

## Paso 1: Verificar Requisitos

Asegúrate de tener instalado:
- ✅ PHP 7.4 o superior
- ✅ PostgreSQL 12 o superior
- ✅ Extensión PDO de PHP habilitada

### Verificar PHP
```bash
php -v
```

### Verificar PostgreSQL
```bash
psql --version
```

### Verificar extensión PDO
```bash
php -m | grep pdo_pgsql
```

Si no aparece `pdo_pgsql`, necesitas instalarlo:
- **macOS**: `brew install php-pgsql`
- **Linux**: `sudo apt-get install php-pgsql` o `sudo yum install php-pgsql`
- **Windows**: Edita `php.ini` y descomenta `extension=pdo_pgsql`

## Paso 2: Configurar la Base de Datos

### 2.1. Editar configuración de conexión

Abre el archivo `config/database.php` y modifica estas líneas según tu configuración:

```php
private const DB_HOST = 'localhost';      // Tu servidor PostgreSQL
private const DB_NAME = 'gimnasio_db';    // Nombre de la base de datos
private const DB_USER = 'postgres';        // Tu usuario de PostgreSQL
private const DB_PASS = 'tu_contraseña';  // Tu contraseña de PostgreSQL
private const DB_PORT = '5432';            // Puerto (por defecto 5432)
```

### 2.2. Crear la base de datos

Abre una terminal y ejecuta:

```bash
# Opción 1: Usando psql directamente
psql -U postgres

# Dentro de psql, ejecuta:
CREATE DATABASE gimnasio_db;
\q

# Opción 2: Desde la línea de comandos
createdb -U postgres gimnasio_db
```

### 2.3. Ejecutar el script SQL

```bash
# Desde la raíz del proyecto
psql -U postgres -d gimnasio_db -f database/schema.sql
```

**Nota**: Si te pide contraseña, ingrésala cuando se solicite.

### 2.4. Verificar que las tablas se crearon

```bash
psql -U postgres -d gimnasio_db -c "\dt"
```

Deberías ver las tablas: `members`, `classes`, `membership_types`, `payments`

## Paso 3: Iniciar el Servidor

### Opción A: Usar el script run.sh (Recomendado - Más fácil)

```bash
# Desde la raíz del proyecto
./run.sh
```

O con un puerto personalizado:
```bash
./run.sh 8080
```

El script automáticamente:
- ✅ Verifica que PHP esté instalado
- ✅ Verifica la extensión PDO PostgreSQL
- ✅ Verifica que PostgreSQL esté ejecutándose
- ✅ Inicia el servidor en el puerto especificado (por defecto 8000)

### Opción B: Servidor PHP Built-in (Manual)

```bash
# Navega a la carpeta public
cd public

# Inicia el servidor
php -S localhost:8000
```

Verás un mensaje como:
```
PHP 7.4.x Development Server (http://localhost:8000) started
```

### Opción B: Usar Apache/Nginx

Si tienes Apache o Nginx configurado:
1. Configura el DocumentRoot apuntando a la carpeta `public/`
2. Asegúrate de que el módulo `mod_rewrite` esté habilitado (Apache)
3. Accede a través de tu dominio configurado

## Paso 4: Acceder a la Aplicación

Abre tu navegador web y visita:

```
http://localhost:8000/index.php
```

O simplemente:

```
http://localhost:8000/index.php?controller=member&action=index
```

## Paso 5: Probar la Aplicación

### 5.1. Gestión de Miembros
- Haz clic en "Miembros" en el menú
- Haz clic en "➕ Nuevo Miembro"
- Completa el formulario y guarda
- Verifica que el miembro aparezca en la lista

### 5.2. Gestión de Clases
- Haz clic en "Clases" en el menú
- Haz clic en "➕ Nueva Clase"
- Completa el formulario y guarda
- Verifica que la clase aparezca en la lista

### 5.3. Gestión de Pagos
- Haz clic en "Pagos" en el menú
- Haz clic en "➕ Registrar Pago"
- Selecciona un miembro y tipo de membresía
- Completa el formulario y guarda

## 🔧 Solución de Problemas Comunes

### Error: "Error de conexión al servidor de base de datos"

**Causa**: PostgreSQL no está ejecutándose o las credenciales son incorrectas.

**Solución**:
```bash
# Verificar que PostgreSQL esté ejecutándose
# macOS/Linux:
sudo service postgresql status
# o
brew services list | grep postgresql

# Iniciar PostgreSQL si no está ejecutándose
# macOS:
brew services start postgresql
# Linux:
sudo service postgresql start
```

### Error: "Base de datos no existe"

**Solución**:
```bash
# Crear la base de datos
createdb -U postgres gimnasio_db

# O usando psql
psql -U postgres
CREATE DATABASE gimnasio_db;
\q
```

### Error: "No se puede conectar al servidor"

**Solución**:
1. Verifica que PostgreSQL esté escuchando en el puerto 5432:
   ```bash
   # macOS/Linux
   lsof -i :5432
   ```
2. Verifica las credenciales en `config/database.php`
3. Verifica que el usuario `postgres` tenga permisos

### Error: "Class 'PDO' not found"

**Solución**: La extensión PDO no está habilitada.
```bash
# Verificar extensión
php -m | grep pdo_pgsql

# Si no aparece, instalar:
# macOS
brew install php-pgsql

# Linux (Ubuntu/Debian)
sudo apt-get install php-pgsql

# Linux (CentOS/RHEL)
sudo yum install php-pgsql
```

### Los estilos CSS no se cargan

**Solución**:
1. Verifica que estés accediendo desde `http://localhost:8000/index.php`
2. Verifica que los archivos CSS existan en `public/assets/css/style.css`
3. Abre las herramientas de desarrollador (F12) y revisa la consola para ver errores 404

### Página en blanco

**Solución**:
1. Activa el display de errores en PHP (solo para desarrollo):
   ```php
   // Agrega al inicio de public/index.php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```
2. Revisa los logs de PHP
3. Verifica que todas las rutas de archivos sean correctas

## 📝 Comandos Rápidos de Referencia

```bash
# 1. Crear base de datos
createdb -U postgres gimnasio_db

# 2. Ejecutar script SQL
psql -U postgres -d gimnasio_db -f database/schema.sql

# 3. Iniciar servidor PHP
cd public
php -S localhost:8000

# 4. Verificar tablas creadas
psql -U postgres -d gimnasio_db -c "\dt"

# 5. Ver datos de ejemplo
psql -U postgres -d gimnasio_db -c "SELECT * FROM members;"
```

## ✅ Checklist de Ejecución

- [ ] PHP instalado y funcionando
- [ ] PostgreSQL instalado y ejecutándose
- [ ] Extensión PDO habilitada
- [ ] Base de datos `gimnasio_db` creada
- [ ] Script SQL ejecutado correctamente
- [ ] Configuración de conexión en `config/database.php` actualizada
- [ ] Servidor PHP iniciado en `localhost:8000`
- [ ] Aplicación accesible en el navegador
- [ ] Puedo crear, editar y eliminar miembros
- [ ] Puedo crear, editar y eliminar clases
- [ ] Puedo registrar pagos

## 🎓 Próximos Pasos

Una vez que la aplicación esté funcionando:

1. Explora el código para entender la arquitectura Cliente-Servidor
2. Revisa `GUIA_ESTUDIANTE.md` para aprender a agregar nuevas funcionalidades
3. Prueba agregar la funcionalidad de "Instructores" siguiendo la guía
4. Experimenta modificando las vistas y estilos

¡Disfruta aprendiendo sobre arquitectura Cliente-Servidor! 🚀

