# 🍞 Kavana Bread

## Setup (Solo la primera vez)

### 1. Instala XAMPP
Descarga e instala desde

### 2. Clona el proyecto
En tu terminal, escribe:
```bash
git clone https://github.com/RyanTL/kavanabread.git
cd kavanabread
```

### 3. Mueve a XAMPP
Copia la carpeta `kavanabread` a:
- **Windows**: `C:\xampp\htdocs`
- **Mac**: `/Applications/XAMPP/xamppfiles/htdocs`

### 4. Inicia Apache
- Abre XAMPP Control Panel
- Haz clic en "Start" junto a **Apache**

### 5. Abre en el navegador
```
http://localhost/kavanabread
```

---

## Reglas del proyecto

### 1. Comenta tu código
Explica qué hace cada parte importante:
```php
// Obtener nombre del formulario
$nombre = $_POST['nombre'];

// Validar que no esté vacío
if (empty($nombre)) {
    echo "Error: nombre requerido";
}
```

### 2. Nombres claros
- Usa nombres descriptivos para archivos y variables
- ✅ Correcto: `validar_usuario.php`
- ❌ Incorrecto: `archivo.php`

### 3. Estructura de carpetas
- Mantén los archivos organizados
- No crees carpetas innecesarias
- Comunica si creas algo nuevo

### 4. Antes de hacer commit
- Verifica que tu código funcione
- Agrega comentarios donde sea necesario
- Escribe un mensaje claro en el commit

---

## Cómo desarrollar

1. Edita los archivos en la carpeta
2. Guarda los cambios **(Ctrl+S)**
3. Recarga el navegador **(F5)**

---

## 🚀 Subir cambios a GitHub

Escribe estos comandos en la terminal:

```bash
git add .
git commit -m "describe los cambios"
git push
```

¡Listo! Tu código está en GitHub.

---
