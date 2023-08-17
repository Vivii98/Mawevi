<?php
require_once "config/conexion.php"; // Asegúrate de incluir tu archivo de configuración aquí

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $searchTerm = mysqli_real_escape_string($conexion, $_GET['q']);

    $query = "SELECT p.*, c.id AS id_cat, c.categoria FROM productos p 
              INNER JOIN categorias c ON c.id = p.id_categoria 
              WHERE p.nombre LIKE '%$searchTerm%' OR p.descripcion LIKE '%$searchTerm%'";
    
    $result = mysqli_query($conexion, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Carrito de Compras</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap icons-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles2.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
    
    <link href="assets/css/estilos.css" rel="stylesheet" />
    <!-- ... (tu encabezado y metadatos) ... -->
</head>
<body>
<a href="#" class="btn-flotante" id="btnCarrito">Carrito <span class="badge bg-success" id="carrito">0</span></a>
    <!-- Navigation-->
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">MAWEVI</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <a href="#" class="nav-link text-info" category="all">Inicio</a>
                        <?php
                        $query = mysqli_query($conexion, "SELECT * FROM categorias");
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <a href="#" class="nav-link" category="<?php echo $data['categoria']; ?>"><?php echo $data['categoria']; ?></a>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
<!-- Search form -->
<form class="d-flex justify-content-center mt-4" method="GET" action="buscar.php">
    <input class="form-control me-2" type="search" name="q" placeholder="Buscar producto" aria-label="Search">
    <button class="btn btn-outline-dark" type="submit">Buscar</button>
</form>


    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">MAWEVI</h1>
                <p class="lead fw-normal text-white-50 mb-0">Consigue todo lo que quieres en ropa a un buen precio.</p>
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $query = mysqli_query($conexion, "SELECT p.*, c.id AS id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id = p.id_categoria");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <div class="col mb-5 productos" category="<?php echo $data['categoria']; ?>">
                            <div class="card h-100">
                                <!-- Sale badge-->
                                <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem"><?php echo ($data['precio_normal'] > $data['precio_rebajado']) ? 'Oferta' : ''; ?></div>
                                <!-- Product image-->
                                <img class="card-img-top" src="assets/img/<?php echo $data['imagen']; ?>" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder"><?php echo $data['nombre'] ?></h5>
                                        <p><?php echo $data['descripcion']; ?></p>
                                        <!-- Product reviews-->
                                        <div class="d-flex justify-content-center small text-warning mb-2">
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                        </div>
                                        <!-- Product price-->
                                        <span class="text-muted text-decoration-line-through"><?php echo $data['precio_normal'] ?></span>
                                        <?php echo $data['precio_rebajado'] ?>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto agregar" data-id="<?php echo $data['id']; ?>" href="#">Agregar</a></div>
                                </div>
                            </div>
                        </div>
                <?php  }
                } ?>

            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <section class="buttons">
                <p class="m-0 text-center text-white">Copyright &copy; Tieda Online Website 2023</p>
                <br>
                <p class="m-0 text-center text-white">Siguenos en Facebook</p>
                <a href="https://www.facebook.com/?stype=lo&jlou=AfdhsKTxzPqPBMmQD5cwGWw3Bs5_THYDLgv0JgGrcAKPXcFv3IArzIMIKpwQXa66EmEe26mICQr5GglGndk2uPtYaIwAdF_ff4re-vPckaISBQ&smuh=24094&lh=Ac-Q2-vlfvm26VkRFfw" class="fa fa-facebook"></a>
                <p class="m-0 text-center text-white">Siguenos en Instagram</p>
                <a href="https://www.instagram.com" class="fa fa-instagram"></a>
            </section>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <!-- ... (tu navegación y encabezado) ... -->

    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                if (isset($result) && mysqli_num_rows($result) > 0) {
                    while ($data = mysqli_fetch_assoc($result)) {

                        
                        // Resto del código para mostrar los productos (misma estructura que antes)
                    }
                } else {
                    echo "<p>No se encontraron resultados para la búsqueda.</p>";
                }
                ?>
            </div>
        </div>
    </section>
    
    <!-- ... (tu pie de página y scripts) ... -->
</body>
</html>
