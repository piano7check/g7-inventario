@extends('layouts.app')

@section('content')
<style>
  .btn-crear {
    background: linear-gradient(to right, #667eea, #764ba2);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    padding: 10px 20px;
    transition: all 0.3s ease-in-out;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .btn-crear:hover {
    background: linear-gradient(to right, #5a6fd8, #6a4190);
    box-shadow: 0 0 15px rgba(102, 126, 234, 0.4);
    transform: translateY(-2px);
  }

  .product-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    background-color: #ffffff;
  }

  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
  }

  .product-img {
    width: 100%;
    height: 180px;
    object-fit: contain;
    background-color: #f8f9ff;
    padding: 1rem;
  }

  .product-info {
    padding: 1rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .product-title {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    color: #2e3d59;
  }

  .product-price {
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 1rem;
    color: #333;
  }

  /* Estilos actualizados para los botones */
  .btn-accion {
    border: none;
    border-radius: 10px;
    font-weight: 600;
    padding: 8px 16px;
    transition: all 0.3s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  .btn-ver {
    background: linear-gradient(to right, #4facfe, #00f2fe);
    color: #fff;
  }

  .btn-ver:hover {
    background: linear-gradient(to right, #3d9efd, #00dff0);
    box-shadow: 0 0 10px rgba(0, 140, 255, 0.3);
    transform: translateY(-2px);
  }

  .btn-editar {
    background: linear-gradient(to right, #f6d365, #fda085);
    color: #fff;
  }

  .btn-editar:hover {
    background: linear-gradient(to right, #f3c95a, #fc9175);
    box-shadow: 0 0 10px rgba(255, 170, 0, 0.3);
    transform: translateY(-2px);
  }

  .btn-eliminar {
    background: linear-gradient(to right, #ff6b6b, #ff8e8e);
    color: #fff;
  }

  .btn-eliminar:hover {
    background: linear-gradient(to right, #ff5c5c, #ff7e7e);
    box-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
    transform: translateY(-2px);
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .product-img {
    width: 100%;
    height: 180px;
    object-fit: contain;
    background-color: #f8f9ff;
    padding: 1rem;
    /* Agregar estas propiedades para mejorar la carga */
    loading: lazy;
    transition: opacity 0.3s ease;
}

.product-img:not([src]) {
    opacity: 0.5;
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="%23f0f0f0"/><text x="50" y="50" text-anchor="middle" dy=".3em" fill="%23999">Cargando...</text></svg>');
    background-repeat: no-repeat;
    background-position: center;
}
</style>

<div class="container-fluid mt-5">
    <h1 class="text-center mb-4 fw-bold display-5 text-primary">Catálogo de Productos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        @if(auth()->user()->rol == 'administrador')
        <button type="button" class="btn-accion btn-crear" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </button>
        @else
        <div></div> <!-- Espacio vacío para mantener el layout cuando el botón no se muestra -->
        @endif

        <form method="GET" action="{{ route('productos.index') }}" class="d-flex gap-2">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o código" value="{{ request('buscar') }}">
            <button type="submit" class="btn-accion btn-ver">Buscar</button>
            <a href="{{ route('productos.index') }}" class="btn-accion btn-eliminar">Limpiar</a>
        </form>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($productos as $producto)
            <div class="col">
                <div class="product-card">
                @if($producto->imagen)
                    <img src="{{ asset('storage/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="product-img">
                @else
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=" alt="{{ $producto->nombre }}" class="product-img">
                @endif
                    <div class="product-info">
                        <h3 class="product-title">{{ $producto->nombre }}</h3>
                        <div class="mt-auto d-flex justify-content-between gap-2">
                            <button class="btn-accion btn-ver" data-bs-toggle="modal" data-bs-target="#modalVer{{ $producto->id_producto }}">
                                <i class="bi bi-eye"></i> Ver
                            </button>
                            @if(auth()->user()->rol == 'administrador')
                            <button class="btn-accion btn-editar" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $producto->id_producto }}">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <button class="btn-accion btn-eliminar" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $producto->id_producto }}">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- 🔽 Modales para ver detalles del producto -->
@foreach($productos as $producto)
<div class="modal fade" id="modalVer{{ $producto->id_producto }}" tabindex="-1" aria-labelledby="modalVerLabel{{ $producto->id_producto }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVerLabel{{ $producto->id_producto }}">Detalles del Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="text-center mb-3">
        @if($producto->imagen)
            <img src="{{ asset('storage/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="product-img">
        @else
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=" alt="{{ $producto->nombre }}" class="product-img">
        @endif  
        </div>
        <h4 class="text-center mb-3">{{ $producto->nombre }}</h4>
        <div class="row">
          <div class="col-md-6 mb-2">
            <p><strong>Código:</strong> {{ $producto->codigo }}</p>
          </div>
          <div class="col-md-6 mb-2">
            <p><strong>Unidad:</strong> {{ $producto->unidad_medida }}</p>
          </div>
          <div class="col-md-6 mb-2">
            <p><strong>Categoría:</strong> {{ $producto->categoria }}</p>
          </div>
          <div class="col-md-6 mb-2">
            <p><strong>Cantidad:</strong> {{ $producto->cantidad }}</p>
          </div>
        </div>
        <div class="mt-3">
          <p><strong>Observación:</strong></p>
          <p>{{ $producto->observacion ?: 'Sin observaciones' }}</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-accion btn-eliminar" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endforeach
<!-- 🔼 Fin de modales para ver detalles -->

<!-- 🔽 Modales de confirmación para eliminar -->
@foreach($productos as $producto)
<div class="modal fade" id="modalEliminar{{ $producto->id_producto }}" tabindex="-1" aria-labelledby="modalEliminarLabel{{ $producto->id_producto }}" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('productos.destroy', $producto->id_producto) }}">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEliminarLabel{{ $producto->id_producto }}">Confirmar Eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar el producto <strong>{{ $producto->nombre }}</strong>?
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn-accion btn-eliminar">Eliminar</button>
          <button type="button" class="btn-accion btn-ver" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach
<!-- 🔼 Fin de modales de eliminación -->

<!-- 🔽 Modales de edición -->
@foreach($productos as $producto)
<div class="modal fade" id="modalEditar{{ $producto->id_producto }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $producto->id_producto }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('productos.update', ['id' => $producto->id_producto]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel{{ $producto->id_producto }}">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" name="codigo" class="form-control" value="{{ $producto->codigo }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Unidad de Medida</label>
                        <input type="text" name="unidad_medida" class="form-control" value="{{ $producto->unidad_medida }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <input type="text" name="categoria" class="form-control" value="{{ $producto->categoria }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" value="{{ $producto->cantidad }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen del Producto</label>
                        @if($producto->imagen)
                            <div class="mb-2">
                                <img src="{{ asset('storage/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="max-height: 100px; max-width: 100%;">
                            </div>
                        @endif
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                        <small class="text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observación</label>
                        <textarea name="observacion" class="form-control">{{ $producto->observacion }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-accion btn-editar">Guardar Cambios</button>
                    <button type="button" class="btn-accion btn-eliminar" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
<!-- 🔼 Fin de modales de edición -->

<!-- Modal para crear producto -->
<div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crearProductoModalLabel">Agregar Nuevo Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="codigo" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Unidad de Medida</label>
            <select name="unidad_medida" class="form-select" required>
              <option value="" selected disabled>Seleccione una unidad</option>
              <option value="Unidad">Unidad</option>
              <option value="kg">kg</option>
              <option value="Lata">Lata</option>
              <option value="Bolsas">Bolsas</option>
              <option value="Paquete">Paquete</option>
              <option value="Caja">Caja</option>
              <option value="Gramos">Gramos</option>
              <option value="Java">Java</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select" required>
              <option value="" selected disabled>Seleccione una categoría</option>
              <option value="Verduras">Verduras</option>
              <option value="Abarrotes">Abarrotes</option>
              <option value="Frutos secos">Frutos secos</option>
              <option value="Frutas">Frutas</option>
              <option value="Semillas">Semillas</option>
              <option value="Enlatados">Enlatados</option>
              <option value="Lácteos">Lácteos</option>
              <option value="Plásticos">Plásticos</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Imagen del Producto</label>
            <input type="file" name="imagen" class="form-control" accept="image/*">
            <small class="text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Observación</label>
            <textarea name="observacion" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn-accion btn-crear">Guardar</button>
          <button type="button" class="btn-accion btn-eliminar" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
    lucide.createIcons();
</script>@extends('layouts.app')

@section('content')
<style>
  .btn-crear {
    background: linear-gradient(to right, #667eea, #764ba2);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    padding: 10px 20px;
    transition: all 0.3s ease-in-out;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .btn-crear:hover {
    background: linear-gradient(to right, #5a6fd8, #6a4190);
    box-shadow: 0 0 15px rgba(102, 126, 234, 0.4);
    transform: translateY(-2px);
  }

  .product-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    background-color: #ffffff;
  }

  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
  }

  .product-img {
    width: 100%;
    height: 180px;
    object-fit: contain;
    background-color: #f8f9ff;
    padding: 1rem;
  }

  .product-info {
    padding: 1rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .product-title {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    color: #2e3d59;
  }

  .product-price {
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 1rem;
    color: #333;
  }

  /* Estilos actualizados para los botones */
  .btn-accion {
    border: none;
    border-radius: 10px;
    font-weight: 600;
    padding: 8px 16px;
    transition: all 0.3s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  .btn-ver {
    background: linear-gradient(to right, #4facfe, #00f2fe);
    color: #fff;
  }

  .btn-ver:hover {
    background: linear-gradient(to right, #3d9efd, #00dff0);
    box-shadow: 0 0 10px rgba(0, 140, 255, 0.3);
    transform: translateY(-2px);
  }

  .btn-editar {
    background: linear-gradient(to right, #f6d365, #fda085);
    color: #fff;
  }

  .btn-editar:hover {
    background: linear-gradient(to right, #f3c95a, #fc9175);
    box-shadow: 0 0 10px rgba(255, 170, 0, 0.3);
    transform: translateY(-2px);
  }

  .btn-eliminar {
    background: linear-gradient(to right, #ff6b6b, #ff8e8e);
    color: #fff;
  }

  .btn-eliminar:hover {
    background: linear-gradient(to right, #ff5c5c, #ff7e7e);
    box-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
    transform: translateY(-2px);
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .product-img {
    width: 100%;
    height: 180px;
    object-fit: contain;
    background-color: #f8f9ff;
    padding: 1rem;
    /* Agregar estas propiedades para mejorar la carga */
    loading: lazy;
    transition: opacity 0.3s ease;
}

.product-img:not([src]) {
    opacity: 0.5;
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="%23f0f0f0"/><text x="50" y="50" text-anchor="middle" dy=".3em" fill="%23999">Cargando...</text></svg>');
    background-repeat: no-repeat;
    background-position: center;
}
</style>

<div class="container-fluid mt-5">
    <h1 class="text-center mb-4 fw-bold display-5 text-primary">Catálogo de Productos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        @if(auth()->user()->rol == 'administrador')
        <button type="button" class="btn-accion btn-crear" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </button>
        @else
        <div></div>         @endif

        <form method="GET" action="{{ route('productos.index') }}" class="d-flex gap-2">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o código" value="{{ request('buscar') }}">
            <button type="submit" class="btn-accion btn-ver">Buscar</button>
            <a href="{{ route('productos.index') }}" class="btn-accion btn-eliminar">Limpiar</a>
        </form>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($productos as $producto)
            <div class="col">
                <div class="product-card">
                @if($producto->imagen)
                    <img src="{{ asset('storage/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="product-img">
                @else
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=" alt="{{ $producto->nombre }}" class="product-img">
                @endif
                    <div class="product-info">
                        <h3 class="product-title">{{ $producto->nombre }}</h3>
                        <div class="mt-auto d-flex justify-content-between gap-2">
                            <button class="btn-accion btn-ver" data-bs-toggle="modal" data-bs-target="#modalVer{{ $producto->id_producto }}">
                                <i class="bi bi-eye"></i> Ver
                            </button>
                            @if(auth()->user()->rol == 'administrador')
                            <button class="btn-accion btn-editar" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $producto->id_producto }}">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <button class="btn-accion btn-eliminar" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $producto->id_producto }}">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@foreach($productos as $producto)
<div class="modal fade" id="modalVer{{ $producto->id_producto }}" tabindex="-1" aria-labelledby="modalVerLabel{{ $producto->id_producto }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVerLabel{{ $producto->id_producto }}">Detalles del Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
      <div class="modal-body">
        <div class="text-center mb-3">
        @if($producto->imagen)
            <img src="{{ asset('storage/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="product-img">
        @else
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=" alt="{{ $producto->nombre }}" class="product-img">
        @endif  
        </div>
        <h4 class="text-center mb-3">{{ $producto->nombre }}</h4>
        <div class="row">
          <div class="col-md-6 mb-2">
            <p><strong>Código:</strong> {{ $producto->codigo }}</p>
          </div>
          <div class="col-md-6 mb-2">
            <p><strong>Unidad:</strong> {{ $producto->unidad_medida }}</p>
          </div>
          <div class="col-md-6 mb-2">
            <p><strong>Categoría:</strong> {{ $producto->categoria }}</p>
          </div>
          <div class="col-md-6 mb-2">
            <p><strong>Cantidad:</strong> {{ $producto->cantidad }}</p>
          </div>
        </div>
        <div class="mt-3">
          <p><strong>Observación:</strong></p>
          <p>{{ $producto->observacion ?: 'Sin observaciones' }}</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-accion btn-eliminar" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endforeach
@foreach($productos as $producto)
<div class="modal fade" id="modalEliminar{{ $producto->id_producto }}" tabindex="-1" aria-labelledby="modalEliminarLabel{{ $producto->id_producto }}" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('productos.destroy', $producto->id_producto) }}">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEliminarLabel{{ $producto->id_producto }}">Confirmar Eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar el producto <strong>{{ $producto->nombre }}</strong>?
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn-accion btn-eliminar">Eliminar</button>
          <button type="button" class="btn-accion btn-ver" data-bs-dismiss="modal">Cancelar</button>
        </div>
        </div>
    </form>
  </div>
</div>
@endforeach
@foreach($productos as $producto)
<div class="modal fade" id="modalEditar{{ $producto->id_producto }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $producto->id_producto }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('productos.update', ['id' => $producto->id_producto]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel{{ $producto->id_producto }}">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" name="codigo" class="form-control" value="{{ $producto->codigo }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Unidad de Medida</label>
                        <input type="text" name="unidad_medida" class="form-control" value="{{ $producto->unidad_medida }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <input type="text" name="categoria" class="form-control" value="{{ $producto->categoria }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" value="{{ $producto->cantidad }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen del Producto</label>
                        @if($producto->imagen)
                            <div class="mb-2">
                                <img src="{{ asset('storage/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="max-height: 100px; max-width: 100%;">
                            </div>
                        @endif
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                        <small class="text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observación</label>
                        <textarea name="observacion" class="form-control">{{ $producto->observacion }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-accion btn-editar">Guardar Cambios</button>
                    <button type="button" class="btn-accion btn-eliminar" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
<div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crearProductoModalLabel">Agregar Nuevo Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="codigo" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Unidad de Medida</label>
            <select name="unidad_medida" class="form-select" required>
              <option value="" selected disabled>Seleccione una unidad</option>
              <option value="Unidad">Unidad</option>
              <option value="kg">kg</option>
              <option value="Lata">Lata</option>
              <option value="Bolsas">Bolsas</option>
              <option value="Paquete">Paquete</option>
              <option value="Caja">Caja</option>
              <option value="Gramos">Gramos</option>
              <option value="Java">Java</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select" required>
              <option value="" selected disabled>Seleccione una categoría</option>
              <option value="Verduras">Verduras</option>
              <option value="Abarrotes">Abarrotes</option>
              <option value="Frutos secos">Frutos secos</option>
              <option value="Frutas">Frutas</option>
              <option value="Semillas">Semillas</option>
              <option value="Enlatados">Enlatados</option>
              <option value="Lácteos">Lácteos</option>
              <option value="Plásticos">Plásticos</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Imagen del Producto</label>
            <input type="file" name="imagen" class="form-control" accept="image/*">
            <small class="text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Observación</label>
            <textarea name="observacion" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn-accion btn-crear">Guardar</button>
          <button type="button" class="btn-accion btn-eliminar" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
    lucide.createIcons();
</script>