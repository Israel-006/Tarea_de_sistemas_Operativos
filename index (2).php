<?php

session_start();
$total_items_carrito = !empty($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUYAYOSTIM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,400;0,500;0,700;1,700&display=swap" rel="stylesheet">
    <style>
        /* --- INICIO DE LA SOLUCIÓN --- */
        /* Reseteo de CSS universal para eliminar márgenes y paddings por defecto de todos los elementos. */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* --- FIN DE LA SOLUCIÓN --- */
        
        /* --- ESTILOS GENERALES Y CORRECCIONES --- */
        /* Se quita 'overflow-x: hidden' porque con el reseteo de arriba ya no es necesario */
        body { 
            font-family: 'Ubuntu', sans-serif; 
            background-color: #f3f4f6; 
        }
        input:focus, textarea:focus, button:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(106, 13, 173, 0.4);
        }
        .header-container { background-color: #6a0dad; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap; }
        .logo { font-style: italic; font-size: 2rem; font-weight: bold; flex-shrink: 0; }
        .nav-links ul { list-style: none; display: flex; gap: 25px; } /* Se eliminó margin y padding redundantes */
        .nav-links a { color: white; text-decoration: none; font-size: 1rem; font-weight: 500; padding: 8px; border-radius: 3px; border: 1px solid transparent; transition: border 0.2s; }
        .nav-links a:hover { border: 1px solid white; }
        .header-icons { display: flex; align-items: center; gap: 25px; }
        .header-icons a { position: relative; color: white; cursor: pointer; text-decoration: none; }
        .header-icons svg { width: 28px; height: 28px; }
        #cart-count { background-color: #ff4d4d; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; position: absolute; top: -8px; right: -10px; }
        .user-info { font-weight: bold; }
        .user-info a { color: white; text-decoration: underline; margin-left: 10px; }
        .hero-section { display: flex; flex-direction: column; justify-content: center; align-items: center; height: 60vh; min-height: 400px; padding: 20px; color: #111827; text-align: center; background-color: white; }
        .hero-title { font-size: 4rem; font-weight: 700; font-style: italic; margin-bottom: 25px; color: #9933F2; }
        .button-container { display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; }
        .ghost-button { font-size: 1rem; color: #111827; text-decoration: none; background-color: transparent; border: 2px solid #111827; padding: 12px 30px; border-radius: 50px; transition: background-color 0.3s ease, color 0.3s ease; cursor: pointer; }
        .ghost-button:hover { background-color: #111827; color: white; }
        .cards-section { background-color: rgb(135, 41, 214); padding: 60px 20px; text-align: center; }
        .cards-container { display: flex; justify-content: center; align-items: stretch; gap: 30px; flex-wrap: wrap; max-width: 1200px; margin: 0 auto; }
        .card { background-color: transparent; border: 1px solid #FFFFFF; border-radius: 20px; color: white; padding: 30px; text-align: center; flex-basis: 200px; flex-grow: 1; display: flex; flex-direction: column; justify-content: center; }
        .card h3 { margin-bottom: 15px; font-size: 1.5rem; }
        .card p { font-size: 1rem; color: #E5E7EB; line-height: 1.6; }
        .product-section { padding: 50px 20px; }
        .section-header { max-width: 1200px; margin: 0 auto 40px auto; text-align: center; }
        .section-title { font-size: 2.5rem; margin-bottom: 20px; color: #111827; }
        #search-form input { width: 100%; max-width: 500px; padding: 12px 20px; border: 1px solid #ccc; border-radius: 20px; font-size: 1rem; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        .product-card { background-color: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15); }
        .product-image { width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden; cursor: pointer; }
        .product-image img { width: 100%; height: 100%; object-fit: contain; }
        .product-info { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; text-align: left; }
        .product-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 10px; color: #111827; cursor: pointer; }
        .product-description { font-size: 0.9rem; color: #6b7280; line-height: 1.5; margin-bottom: 15px; flex-grow: 1; }
        .product-price { font-size: 1.4rem; font-weight: 700; color: #4f46e5; margin-bottom: 15px; }
        .add-to-cart-btn { display: block; width: 100%; padding: 12px; border: none; background-color: #111827; color: white; border-radius: 8px; font-size: 1rem; font-weight: 500; cursor: pointer; transition: background-color 0.3s ease; }
        .add-to-cart-btn:hover { background-color: #374151; }
        .footer-container { font-family: Arial, sans-serif; color: white; }
        .footer-main { background-color: #6a0dad; padding: 40px 20px; }
        .footer-content { display: flex; justify-content: space-around; flex-wrap: wrap; gap: 40px; text-align: left; max-width: 900px; margin: 0 auto; }
        .footer-section h3 { margin-top: 0; margin-bottom: 20px; font-size: 1.2rem; }
        .footer-section p { margin: 10px 0; font-size: 0.9rem; }
        .social-icons { display: flex; gap: 15px; margin-top: 15px; }
        .social-icons a { color: white; text-decoration: none; border: 1px solid white; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; transition: background-color 0.3s; }
        .social-icons a:hover { background-color: rgba(255,255,255,0.2); }
        .footer-bottom { background-color: #56088f; text-align: center; padding: 20px; }
        .footer-bottom p { margin: 0; font-size: 0.9rem; }
        .modal-backdrop { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: flex; justify-content: center; align-items: center; z-index: 3000; opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease; }
        .modal-content, .modal-details-content { background: white; padding: 40px; border-radius: 15px; width: 90%; max-width: 400px; text-align: center; position: relative; color: #111827; }
        .modal-details-content { max-width: 800px; display: flex; gap: 30px; padding: 30px; }
        .modal-content form div { margin-bottom: 20px; text-align: left; }
        .modal-content label { display: block; margin-bottom: 5px; font-weight: bold; }
        .modal-content input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; }
        .modal-content button:not(.modal-close-btn) { width: 100%; padding: 15px; background: #6a0dad; color: white; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer; }
        .modal-content p { margin-top: 15px; }
        .modal-content a { color: #6a0dad; font-weight: bold; text-decoration: none; }
        .modal-details-image { flex: 1; max-width: 40%; align-self: center; }
        .modal-details-image img { width: 100%; height: auto; border-radius: 10px; }
        .modal-details-info { flex: 1.5; text-align: left; }
        .modal-details-title { font-size: 2.2rem; margin-top: 0; margin-bottom: 15px; }
        .modal-details-price { font-size: 1.8rem; font-weight: bold; color: #4f46e5; margin-bottom: 20px; }
        .modal-details-description { font-size: 1rem; line-height: 1.6; margin-bottom: 20px; }
        .modal-details-extra { background-color: #f3f4f6; padding: 15px; border-radius: 8px; font-size: 0.9rem; }
        .modal-close-btn { position: absolute; top: 15px; right: 20px; background: transparent; border: none; font-size: 2.5rem; font-weight: bold; cursor: pointer; color: #6a0dad; padding: 0; line-height: 1; }
        
        @media (max-width: 768px) {
            .header-container { flex-direction: column; padding: 15px; }
            .nav-links ul { gap: 15px; flex-wrap: wrap; justify-content: center; padding-top: 10px; }
            .hero-title { font-size: 2.8rem; }
            .modal-details-content { flex-direction: column; }
            .modal-details-image { max-width: 100%; }
        }
    </style>
</head>
<body>

    <!-- ENCABEZADO -->
    <header class="header-container">
        <div class="logo">MuyayosTim</div>
        <nav class="nav-links">
            <ul>
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#productos">Productos</a></li>
                <li><a href="#contactos">Contactos</a></li>
                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                    <li><a href="admin.php" style="background-color: #ffc107; color: #333; border-radius: 5px;">Panel Admin</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="header-icons">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <div class="user-info">
                    <span>Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
                    <a href="logout.php">Salir</a>
                </div>
            <?php else: ?>
                <a id="login-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </a>
            <?php endif; ?>
            <a href="carrito.php">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                <span id="cart-count"><?php echo $total_items_carrito; ?></span>
            </a>
        </div>
    </header>

    <!-- MODAL DE LOGIN Y REGISTRO -->
    <div id="login-modal" class="modal-backdrop">
        <div class="modal-content">
            <button class="modal-close-btn">&times;</button>
            <h2 id="modal-title">Iniciar Sesión</h2>
            <div id="modal-message" style="display: none; padding: 10px; margin-bottom: 15px; border-radius: 5px; font-weight: bold;"></div>
            <div id="login-form-container">
                <form id="login-form">
                    <div><label for="login-email">Correo Electrónico</label><input type="email" id="login-email" name="correo" required></div>
                    <div><label for="login-password">Contraseña</label><input type="password" id="login-password" name="contrasena" required></div>
                    <button type="submit">Ingresar</button>
                </form>
                <p>¿No tienes una cuenta? <a href="#" id="show-register-link">Regístrate</a></p>
            </div>
            <div id="register-form-container" style="display: none;">
                <form id="register-form">
                    <div><label for="register-name">Nombre Completo</label><input type="text" id="register-name" name="nombre_completo" required></div>
                    <div><label for="register-email">Correo Electrónico</label><input type="email" id="register-email" name="correo" required></div>
                    <div><label for="register-password">Contraseña</label><input type="password" id="register-password" name="contrasena" required></div>
                    <button type="submit">Crear Cuenta</button>
                </form>
                <p>¿Ya tienes una cuenta? <a href="#" id="show-login-link">Inicia Sesión</a></p>
            </div>
        </div>
    </div>
    
    <main>
        <!-- SECCIÓN DE BIENVENIDA -->
        <section id="inicio" class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">¡Bienvenido a MuyayosTim!</h1>
                <div class="button-container">
                    <a href="#productos" class="ghost-button">Productos</a>
                    <a href="#contactos" class="ghost-button">Contactos</a>
                </div>
            </div>
        </section>

        <!-- SECCIÓN DE MARCAS  -->
        <section class="cards-section">
            <div class="cards-container">
                <div class="card"><h3>Samsung</h3><p>Variedad de productos electrónicos, desde teléfonos y televisores hasta electrodomésticos.</p></div>
                <div class="card"><h3>iPhone</h3><p>Teléfonos inteligentes de alta gama de Apple, famosa por su diseño y sistema operativo iOS.</p></div>
                <div class="card"><h3>Xiaomi</h3><p>Productos de electrónica, especialmente teléfonos, con buena tecnología a precios muy competitivos.</p></div>
                <div class="card"><h3>Nvidia</h3><p>Tarjetas graficas potentes con algunos modelos con IA </p></div>
            </div>
        </section>

        <!-- SECCIÓN DE PRODUCTOS -->
        <section id="productos" class="product-section">
            <div class="section-header">
                <h2 class="section-title">Nuestros Productos</h2>
                <form id="search-form" onsubmit="return false;"><input id="search-input" type="text" placeholder="Buscar productos..."></form>
            </div>
            <div class="product-grid"></div>
        </section>
    </main>

    <!-- PIE DE PÁGINA  -->
    <footer id="contactos" class="footer-container">
        <div class="footer-main">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <p>sopertemuyatim@gmail.com</p>
                    <p>+593 981148284</p>
                </div>
                <div class="footer-section social">
                    <h3>Síguenos</h3>
                    <div class="social-icons">
                        <a href="https://www.instagram.com/israel_16j/" target="_blank" title="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                        <a href="https://www.tiktok.com/@israel._.xd_?is_from_webapp=1&sender_device=pc" target="_blank" title="TikTok">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 MUYAYOSTIM. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- VENTANILLA DE DETALLES DE PRODUCTO -->
    <div id="product-details-modal" class="modal-backdrop">
        <div class="modal-details-content">
            <button class="modal-close-btn">&times;</button>
            <div class="modal-details-image">
                <img id="details-img" src="" alt="Imagen del producto">
            </div>
            <div class="modal-details-info">
                <h2 id="details-title" class="modal-details-title"></h2>
                <div id="details-price" class="modal-details-price"></div>
                <p id="details-description" class="modal-details-description"></p>
                <div class="modal-details-extra">
                    <h3>Más Información:</h3>
                    <p id="details-extra-info"></p>
                </div>
                <button class="add-to-cart-btn" style="margin-top: 20px;">Añadir al carrito</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        
        if ('scrollRestoration' in history) { history.scrollRestoration = 'manual'; }
        window.scrollTo({ top: 0, behavior: 'instant' });
        
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (targetId && targetId.startsWith('#')) {
                    e.preventDefault();
                    document.querySelector(targetId).scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
        
        const productGrid = document.querySelector('.product-grid');
        let allProducts = [];
        
        function renderProducts(productsToRender) {
            productGrid.innerHTML = '';
            if (!productsToRender || productsToRender.length === 0) {
                productGrid.innerHTML = '<p style="text-align: center; grid-column: 1 / -1;">No hay productos en la tienda.</p>';
                return;
            }
            productsToRender.forEach(product => {
                const productCardHTML = `
                    <div class="product-card" data-id="${product.id}">
                        <div class="product-image"><img src="${product.imagen_url}" alt="${product.nombre}" onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/ffffff?text=Imagen no disponible';"></div>
                        <div class="product-info">
                            <h3 class="product-title">${product.nombre}</h3>
                            <p class="product-description">${product.descripcion}</p>
                            <div class="product-price">$${parseFloat(product.precio).toFixed(2)}</div>
                            <button class="add-to-cart-btn" data-id="${product.id}">Añadir al carrito</button>
                        </div>
                    </div>`;
                productGrid.innerHTML += productCardHTML;
            });
        }

        function loadProducts() {
            fetch('get_products.php').then(r => r.json()).then(result => {
                if (result.success) {
                    allProducts = result.data;
                    renderProducts(allProducts);
                } else { throw new Error(result.message); }
            }).catch(e => {
                console.error('Error al cargar productos:', e);
                productGrid.innerHTML = `<p style="text-align: center; grid-column: 1 / -1;">Error al cargar los productos.</p>`;
            });
        }
        loadProducts();

        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const filteredProducts = allProducts.filter(p => p.nombre.toLowerCase().includes(searchTerm));
            renderProducts(filteredProducts);
        });

        const cartCountElement = document.getElementById('cart-count');
        productGrid.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-to-cart-btn')) {
                const productId = e.target.dataset.id;
                const formData = new FormData();
                formData.append('id_producto', productId);
                fetch('agregar_al_carrito.php', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        cartCountElement.textContent = result.total_items;
                    }
                });
            }
        });

        const loginModal = document.getElementById('login-modal');
        const detailsModal = document.getElementById('product-details-modal');
        const loginIcon = document.getElementById('login-icon');
        if (loginIcon) loginIcon.addEventListener('click', () => {
            loginModal.style.opacity = '1';
            loginModal.style.visibility = 'visible';
        });
        document.querySelectorAll('.modal-close-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.closest('.modal-backdrop').style.opacity = '0';
                btn.closest('.modal-backdrop').style.visibility = 'hidden';
            });
        });
        window.addEventListener('click', e => {
            if (e.target.classList.contains('modal-backdrop')) {
                e.target.style.opacity = '0';
                e.target.style.visibility = 'hidden';
            }
        });
        productGrid.addEventListener('click', (e) => {
            const card = e.target.closest('.product-card');
            if (card && !e.target.classList.contains('add-to-cart-btn')) {
                const productId = card.dataset.id;
                const productData = allProducts.find(p => p.id == productId);
                if (productData) {
                    document.getElementById('details-img').src = productData.imagen_url;
                    document.getElementById('details-title').textContent = productData.nombre;
                    document.getElementById('details-price').textContent = `$${parseFloat(productData.precio).toFixed(2)}`;
                    document.getElementById('details-description').textContent = productData.descripcion;
                    document.getElementById('details-extra-info').textContent = productData.detalles || 'No hay información adicional disponible.';
                    detailsModal.style.opacity = '1';
                    detailsModal.style.visibility = 'visible';
                }
            }
        });
        const loginContainer = document.getElementById('login-form-container');
        const registerContainer = document.getElementById('register-form-container');
        const showRegisterLink = document.getElementById('show-register-link');
        const showLoginLink = document.getElementById('show-login-link');
        const modalTitle = document.getElementById('modal-title');
        const messageBox = document.getElementById('modal-message');
        showRegisterLink.addEventListener('click', e => { e.preventDefault(); loginContainer.style.display = 'none'; registerContainer.style.display = 'block'; modalTitle.textContent = 'Crear Cuenta'; messageBox.style.display = 'none'; });
        showLoginLink.addEventListener('click', e => { e.preventDefault(); registerContainer.style.display = 'none'; loginContainer.style.display = 'block'; modalTitle.textContent = 'Iniciar Sesión'; messageBox.style.display = 'none'; });
        const registerForm = document.getElementById('register-form');
        registerForm.addEventListener('submit', function(e) {
             e.preventDefault();
            const formData = new FormData(this);
            fetch('register.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(result => {
                messageBox.textContent = result.message;
                messageBox.style.backgroundColor = result.success ? '#d4edda' : '#f8d7da';
                messageBox.style.color = result.success ? '#155724' : '#721c24';
                messageBox.style.display = 'block';
                if (result.success) {
                    registerForm.reset();
                    setTimeout(() => showLoginLink.click(), 2000);
                }
            });
        });
        const loginForm = document.getElementById('login-form');
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('login.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(result => {
                messageBox.textContent = result.message;
                messageBox.style.backgroundColor = result.success ? '#d4edda' : '#f8d7da';
                messageBox.style.color = result.success ? '#155724' : '#721c24';
                messageBox.style.display = 'block';
                if (result.success) {
                    setTimeout(() => {
                        if (result.redirect) { window.location.href = result.redirect; } 
                        else { window.location.reload(); }
                    }, 1500);
                }
            });
        });
    });
    </script>

</body>
</html>
