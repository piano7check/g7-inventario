@extends('layouts.app')

@section('title', 'Usuarios')

@section('content') 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Stock - Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f5f5f5;
        }
        
        /* Barra de navegación superior */
        .top-nav {
            background-color: #333;
            color: white;
            padding: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        
        .top-nav-left {
            display: flex;
            align-items: center;
        }
        
        .top-nav-right {
            display: flex;
            align-items: center;
        }
        
        .nav-icon {
            color: white;
            margin: 0 5px;
            cursor: pointer;
        }
           
        /* Contenido principal */
        .main-content {
            margin-left: 200px;
            padding: 80px 20px 20px;
            width: calc(100% - 200px);
        }
        
        .content-container {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        /* Barra de acción */
        .action-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            align-items: center;
        }
        
        .left-actions {
            display: flex;
        }
        
        .action-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            margin-right: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .action-button:hover {
            background-color: #45a049;
        }
        
        .action-button.export {
            background-color: #2196F3;
        }
        
        .action-button.export:hover {
            background-color: #0b7dda;
        }
        
        .search-input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 250px;
        }
        
        /* Tabla de usuarios */
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .users-table th, .users-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        
        .users-table th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
        }
        
        .users-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .users-table tr:hover {
            background-color: #f1f1f1;
        }
        
        .action-cell a {
            text-decoration: none;
            color: #0066cc;
            margin: 0 5px;
        }
        
        .action-cell a:hover {
            text-decoration: underline;
        }
        
        /* Formulario modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 70%;
            max-width: 800px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            animation: modalopen 0.4s;
            margin-left: calc(200px + 15%);
        }
        
        @keyframes modalopen {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close-button:hover {
            color: black;
        }
        
        .form-title {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        
        .form-group {
            flex: 1 0 calc(50% - 20px);
            margin: 0 10px 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .form-buttons {
            text-align: center;
            margin-top: 20px;
        }
        
        .form-buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .save-button {
            background-color: #4CAF50;
            color: white;
        }
        
        .cancel-button {
            background-color: #f44336;
            color: white;
        }
        
        .logout-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>
<body> 
    <!-- Contenido principal -->
    <div class="main-content">
        <div class="content-container">
            <div class="action-bar">
                <div class="left-actions">
                    <button class="action-button" id="crearButton">Crear</button>
                    <button class="action-button export">Exportar</button>
                </div>
                <input type="text" class="search-input" placeholder="Buscar usuario..." id="buscarUsuario">
            </div>
            
            <div class="table-container">
                <table class="users-table" id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>CI</th>
                            <th>Teléfono</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTabla">
                        <!-- Los datos se cargarán dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal de formulario -->
    <div id="crearModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>
            <h2 class="form-title">Crear Nuevo Usuario</h2>
            <form id="formUsuario">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ci">CI:</label>
                        <input type="text" id="ci" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="rol">Rol:</label>
                        <select id="rol" class="form-control" required>
                            <option value="">Seleccione un rol</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Usuario">Usuario</option>
                            <option value="Editor">Editor</option>
                            <option value="Invitado">Invitado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="save-button">Guardar</button>
                    <button type="button" class="cancel-button" id="cancelarForm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Datos de ejemplo para la tabla
        const usuarios = [
            {
                id: 1,
                nombre: 'Juan',
                apellido: 'Pérez',
                ci: '1234567',
                telefono: '555-123-4567',
                usuario: 'jperez',
                contrasena: '••••••••',
                email: 'juan.perez@ejemplo.com',
                rol: 'Administrador',
                fecha: '2025-04-10'
            },
            {
                id: 2,
                nombre: 'María',
                apellido: 'López',
                ci: '7654321',
                telefono: '555-765-4321',
                usuario: 'mlopez',
                contrasena: '••••••••',
                email: 'maria.lopez@ejemplo.com',
                rol: 'Usuario',
                fecha: '2025-04-12'
            }
        ];

        // Cargar tabla al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            cargarTablaUsuarios();
            
            // Configurar fecha actual en el formulario
            const hoy = new Date();
            const fechaFormateada = hoy.toISOString().substr(0, 10);
            document.getElementById('fecha').value = fechaFormateada;
            
            // Configurar eventos para el modal
            const modal = document.getElementById('crearModal');
            const btnCrear = document.getElementById('crearButton');
            const btnCerrar = document.getElementById('closeModal');
            const btnCancelar = document.getElementById('cancelarForm');
            const formUsuario = document.getElementById('formUsuario');
            
            btnCrear.addEventListener('click', function() {
                modal.style.display = 'block';
            });
            
            btnCerrar.addEventListener('click', function() {
                modal.style.display = 'none';
            });
            
            btnCancelar.addEventListener('click', function() {
                modal.style.display = 'none';
            });
            
            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
            
            // Manejar envío del formulario
            formUsuario.addEventListener('submit', function(event) {
                event.preventDefault();
                guardarUsuario();
            });
            
            // Configurar búsqueda
            document.getElementById('buscarUsuario').addEventListener('keyup', buscarUsuarios);
        });
        
        // Cargar usuarios en la tabla
        function cargarTablaUsuarios() {
            const cuerpoTabla = document.getElementById('cuerpoTabla');
            cuerpoTabla.innerHTML = '';
            
            if (usuarios.length === 0) {
                const fila = document.createElement('tr');
                fila.innerHTML = '<td colspan="10" style="text-align: center;">No hay usuarios registrados</td>';
                cuerpoTabla.appendChild(fila);
                return;
            }
            
            usuarios.forEach(usuario => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${usuario.nombre}</td>
                    <td>${usuario.apellido}</td>
                    <td>${usuario.ci}</td>
                    <td>${usuario.telefono}</td>
                    <td>${usuario.usuario}</td>
                    <td>${usuario.contrasena}</td>
                    <td>${usuario.email}</td>
                    <td>${usuario.rol}</td>
                    <td>${formatearFecha(usuario.fecha)}</td>
                    <td class="action-cell">
                        <a href="#" onclick="verUsuario(${usuario.id})">Ver</a> |
                        <a href="#" onclick="editarUsuario(${usuario.id})">Editar</a> |
                        <a href="#" onclick="eliminarUsuario(${usuario.id})">Eliminar</a>
                    </td>
                `;
                cuerpoTabla.appendChild(fila);
            });
        }
        
        // Función para guardar usuario
        function guardarUsuario() {
            const nuevoUsuario = {
                id: usuarios.length + 1,
                nombre: document.getElementById('nombre').value,
                apellido: document.getElementById('apellido').value,
                ci: document.getElementById('ci').value,
                telefono: document.getElementById('telefono').value,
                usuario: document.getElementById('usuario').value,
                contrasena: '••••••••', // Ocultar contraseña en la tabla
                email: document.getElementById('email').value,
                rol: document.getElementById('rol').value,
                fecha: document.getElementById('fecha').value
            };
            
            usuarios.push(nuevoUsuario);
            cargarTablaUsuarios();
            
            // Cerrar modal y limpiar formulario
            document.getElementById('crearModal').style.display = 'none';
            document.getElementById('formUsuario').reset();
            
            // Establecer fecha actual de nuevo
            const hoy = new Date();
            const fechaFormateada = hoy.toISOString().substr(0, 10);
            document.getElementById('fecha').value = fechaFormateada;
            
            alert('Usuario guardado correctamente');
        }
        
        // Funciones para acciones de usuario
        function verUsuario(id) {
            const usuario = usuarios.find(u => u.id === id);
            if (usuario) {
                alert(`Información del usuario:\n
                Nombre: ${usuario.nombre} ${usuario.apellido}
                CI: ${usuario.ci}
                Teléfono: ${usuario.telefono}
                Usuario: ${usuario.usuario}
                Email: ${usuario.email}
                Rol: ${usuario.rol}
                Fecha: ${formatearFecha(usuario.fecha)}`);
            }
        }
        
        function editarUsuario(id) {
            const usuario = usuarios.find(u => u.id === id);
            if (usuario) {
                // Llenar formulario con datos del usuario
                document.getElementById('nombre').value = usuario.nombre;
                document.getElementById('apellido').value = usuario.apellido;
                document.getElementById('ci').value = usuario.ci;
                document.getElementById('telefono').value = usuario.telefono;
                document.getElementById('usuario').value = usuario.usuario;
                document.getElementById('contrasena').value = ''; // Por seguridad, no rellenamos contraseña
                document.getElementById('email').value = usuario.email;
                document.getElementById('rol').value = usuario.rol;
                document.getElementById('fecha').value = usuario.fecha;
                
                // Mostrar modal
                document.getElementById('crearModal').style.display = 'block';
                
                // Cambiar comportamiento del guardar para actualizar en lugar de crear
                const formUsuario = document.getElementById('formUsuario');
                formUsuario.onsubmit = function(event) {
                    event.preventDefault();
                    
                    // Actualizar usuario
                    usuario.nombre = document.getElementById('nombre').value;
                    usuario.apellido = document.getElementById('apellido').value;
                    usuario.ci = document.getElementById('ci').value;
                    usuario.telefono = document.getElementById('telefono').value;
                    usuario.usuario = document.getElementById('usuario').value;
                    usuario.email = document.getElementById('email').value;
                    usuario.rol = document.getElementById('rol').value;
                    usuario.fecha = document.getElementById('fecha').value;
                    
                    cargarTablaUsuarios();
                    document.getElementById('crearModal').style.display = 'none';
                    
                    // Restaurar comportamiento normal del formulario
                    formUsuario.onsubmit = function(e) {
                        e.preventDefault();
                        guardarUsuario();
                    };
                    
                    alert('Usuario actualizado correctamente');
                };
            }
        }
        
        function eliminarUsuario(id) {
            if (confirm('¿Está seguro de que desea eliminar este usuario?')) {
                const index = usuarios.findIndex(u => u.id === id);
                if (index !== -1) {
                    usuarios.splice(index, 1);
                    cargarTablaUsuarios();
                    alert('Usuario eliminado correctamente');
                }
            }
        }
        
        // Función para buscar usuarios
        function buscarUsuarios() {
            const filtro = document.getElementById('buscarUsuario').value.toUpperCase();
            const filas = document.getElementById('tablaUsuarios').getElementsByTagName('tr');
            
            for (let i = 1; i < filas.length; i++) { // Empezamos en 1 para saltar el encabezado
                const celdas = filas[i].getElementsByTagName('td');
                let mostrar = false;
                
                for (let j = 0; j < celdas.length - 1; j++) { // Excluimos la última columna (acciones)
                    const texto = celdas[j].textContent || celdas[j].innerText;
                    if (texto.toUpperCase().indexOf(filtro) > -1) {
                        mostrar = true;
                        break;
                    }
                }
                
                filas[i].style.display = mostrar ? '' : 'none';
            }
        }
        
        // Función para formatear fecha
        function formatearFecha(fechaStr) {
            if (!fechaStr) return '';
            
            // Convertir formato YYYY-MM-DD a DD/MM/YYYY
            const partes = fechaStr.split('-');
            if (partes.length === 3) {
                return `${partes[2]}/${partes[1]}/${partes[0]}`;
            }
            
            return fechaStr;
        }
    </script>
</body>
@endsection
