#!/bin/bash

# Script para ejecutar el servidor PHP del Sistema de Gestión de Gimnasio
# Arquitectura Cliente-Servidor con MVC

# Colores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  Sistema de Gestión de Gimnasio${NC}"
echo -e "${BLUE}  Arquitectura Cliente-Servidor${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# Función para encontrar PHP
find_php() {
    # Rutas comunes donde puede estar PHP en macOS
    PHP_PATHS=(
        "/opt/homebrew/Cellar/php/8.5.0/bin/php"
        "/opt/homebrew/bin/php"
        "/usr/bin/php"
        "/usr/local/bin/php"
        "$(which php 2>/dev/null)"
    )
    
    for php_path in "${PHP_PATHS[@]}"; do
        if [ -f "$php_path" ] && [ -x "$php_path" ]; then
            if "$php_path" -v > /dev/null 2>&1; then
                echo "$php_path"
                return 0
            fi
        fi
    done
    
    return 1
}

# Verificar si PHP está instalado
echo -e "${YELLOW}[1/4] Verificando PHP...${NC}"
PHP_CMD=$(find_php)

if [ -z "$PHP_CMD" ]; then
    echo -e "${RED}❌ PHP no encontrado${NC}"
    echo -e "${YELLOW}Por favor instala PHP:${NC}"
    echo -e "  macOS: brew install php"
    echo -e "  Linux: sudo apt-get install php"
    exit 1
fi

PHP_VERSION=$($PHP_CMD -v | head -n 1)
echo -e "${GREEN}✅ PHP encontrado: $PHP_VERSION${NC}"

# Verificar extensión PDO PostgreSQL
echo -e "${YELLOW}[2/4] Verificando extensión PDO PostgreSQL...${NC}"
if ! $PHP_CMD -m | grep -q "pdo_pgsql"; then
    echo -e "${RED}⚠️  Advertencia: Extensión pdo_pgsql no encontrada${NC}"
    echo -e "${YELLOW}Si tienes errores de conexión, instala la extensión:${NC}"
    echo -e "  macOS: brew install php-pgsql"
    echo -e "  Linux: sudo apt-get install php-pgsql"
else
    echo -e "${GREEN}✅ Extensión PDO PostgreSQL encontrada${NC}"
fi

# Verificar que PostgreSQL esté ejecutándose
echo -e "${YELLOW}[3/4] Verificando PostgreSQL...${NC}"
if command -v psql &> /dev/null; then
    if pg_isready -h localhost -p 5432 > /dev/null 2>&1; then
        echo -e "${GREEN}✅ PostgreSQL está ejecutándose${NC}"
    else
        echo -e "${YELLOW}⚠️  PostgreSQL no parece estar ejecutándose${NC}"
        echo -e "${YELLOW}Inicia PostgreSQL con:${NC}"
        echo -e "  macOS: brew services start postgresql"
        echo -e "  Linux: sudo service postgresql start"
    fi
else
    echo -e "${YELLOW}⚠️  psql no encontrado en PATH${NC}"
    echo -e "${YELLOW}Asegúrate de que PostgreSQL esté instalado${NC}"
fi

# Navegar a la carpeta public
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PUBLIC_DIR="$SCRIPT_DIR/public"

if [ ! -d "$PUBLIC_DIR" ]; then
    echo -e "${RED}❌ Error: Carpeta public/ no encontrada${NC}"
    exit 1
fi

# Verificar que index.php existe
if [ ! -f "$PUBLIC_DIR/index.php" ]; then
    echo -e "${RED}❌ Error: index.php no encontrado en public/${NC}"
    exit 1
fi

# Configurar puerto
PORT=${1:-8000}
HOST=${2:-localhost}

echo -e "${YELLOW}[4/4] Iniciando servidor...${NC}"
echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  Servidor iniciado exitosamente${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "${BLUE}📍 URL:${NC} http://$HOST:$PORT/index.php"
echo ""
echo -e "${BLUE}📋 Rutas disponibles:${NC}"
echo -e "  • Miembros:    http://$HOST:$PORT/index.php?controller=member&action=index"
echo -e "  • Clases:      http://$HOST:$PORT/index.php?controller=class&action=index"
echo -e "  • Pagos:       http://$HOST:$PORT/index.php?controller=payment&action=index"
echo ""
echo -e "${YELLOW}Presiona Ctrl+C para detener el servidor${NC}"
echo ""

# Cambiar al directorio public y ejecutar el servidor
cd "$PUBLIC_DIR"
$PHP_CMD -S $HOST:$PORT

