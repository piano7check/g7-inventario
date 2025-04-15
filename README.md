 Instalación del sistema System_Stock_UAB

📁 Paso 1: Descomprimir el proyecto

Debes clonar el proyecto dentro de la carpeta htdocs de XAMPP o lararacon dentro de www.

📍 Ejemplo de ruta:

C:\xampp\htdocs\System_Stock_UAB 
o si estas usando laragon:
C:\laragon\www\System_Stock_UAB

💻 Paso 2: Abrir el proyecto en Visual Studio Code

💬 Paso 3: Ejecutar los siguientes comandos en la terminal

composer install

npm install

cp .env.example .env

php artisan key:generate

🛠️ Paso 4: Configurar el archivo .env

Edita el archivo .env con los datos de tu base de datos:

DB_DATABASE=system_stock_uab
DB_USERNAME=root
DB_PASSWORD=

🧱 Paso 5: Migraciones (uno por uno si deseas verificar errores)

php artisan migrate

🚀 Paso 6: subir usuario y contraseña con el siguiente comando

php artisan db:seed

🎨 Paso 7: Cargar estilos y assets

php artisan serve

Ahora el sistema debería estar funcionando correctamente en tu red local ✅
