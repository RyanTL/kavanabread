<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <script src = "https://kit.fontawesome.com/bde2b79879.js" crossorigin = "anonymous"></script>
    <link rel = "stylesheet" href = "styles/menu-principal.css">
    <title>Kavana Bread | Menu Principal</title>
</head>

<body>
    <div class="topBarContainer">
        <div class="topBarInner">
            <div class="topBarContent-right">
                <a href="menu-principal.php">
                    <img src="images/Kavana_logo.png" alt="Kavana Bread" class="mainLogo">
                </a>

                <nav class="navLinks">
                    <a href="menu-principal.php" class="nav-link active">Menú</a>
                    <a href="seccionpanes.php" class="nav-link">Panes</a>
                    <a href="seccionartesanal.php" class="nav-link">Artesanal</a>
                    <a href="seccionotros.php" class="nav-link">Otros</a>
                </nav>
            </div>

            <div class = "topBarContent-left">
                <a href="#" class="navIcon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                            19.79 19.79 0 0 1-8.63-3.07
                            19.5 19.5 0 0 1-6-6
                            19.79 19.79 0 0 1-3.07-8.67
                            A2 2 0 0 1 4.11 2h3
                            a2 2 0 0 1 2 1.72
                            12.5 12.5 0 0 0 .7 2.81
                            a2 2 0 0 1-.45 2.11L8.09 9.91
                            a16 16 0 0 0 6 6l1.27-1.27
                            a2 2 0 0 1 2.11-.45
                            12.5 12.5 0 0 0 2.81.7
                            A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </a>
                <a href="#" class="navIcon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <path d="M22 7l-10 7L2 7"/>
                    </svg>
                </a>
                <a href="#" class="navIcon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13
                                a9 9 0 1 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </a>
                <a href="#" class="navIcon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39
                                a2 2 0 0 0 2 1.61h9.72
                                a2 2 0 0 0 2-1.61L23 6H6"/>
                   </svg>
                </a>

                <div class="userContainer">
                    <a href="#" class="navIcon" id="userIconBtn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8
                                    a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </a>

                    <div class="userContent" id="userContent">
                        <a href="#" id="exitButton">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="products-section">
        <h2 class="section-title">Panes más comprados</h2>
        <div class="products-grid">

            <div class="product-card">
                <img src="images/pan_blanco.jpeg" alt="Pan Campesino">

                <div class="product-info">
                    <h3>Pan Blanco</h3>
                    <div class="product-footer">
                        <button class="add-cart-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39
                                        a2 2 0 0 0 2 1.61h9.72
                                        a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Ver más
                        </button>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <img src="images/pan_de_canela.jpeg" alt="Pan Campesino">

                <div class="product-info">
                    <h3>Pan de Canela</h3>
                    <div class="product-footer">
                        <button class="add-cart-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39
                                        a2 2 0 0 0 2 1.61h9.72
                                        a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Ver más
                        </button>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <img src="images/cucumba.jpeg" alt="Pan Campesino">

                <div class="product-info">
                    <h3>Cucumba Chiquito</h3>
                    <div class="product-footer">
                        <button class="add-cart-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39
                                        a2 2 0 0 0 2 1.61h9.72
                                        a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Ver más
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <h2 class="section-title">Artesanales favoritos</h2>
        <div class="products-grid">

            <div class="product-card">
                <img src="images/mantequilla_de_cilantro.jpeg" alt="Pan Campesino">

                <div class="product-info">
                    <h3>Mantequilla de Cilantro</h3>
                    <div class="product-footer">
                        <button class="add-cart-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39
                                        a2 2 0 0 0 2 1.61h9.72
                                        a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Ver más
                        </button>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <img src="images/mermelada_de_fresa.jpeg" alt="Pan Campesino">

                <div class="product-info">
                    <h3>Mermelada de Fresa</h3>
                    <div class="product-footer">
                        <button class="add-cart-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39
                                        a2 2 0 0 0 2 1.61h9.72
                                        a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Ver más
                        </button>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <img src="images/mermelada_de_blueberry.jpeg" alt="Pan Campesino">

                <div class="product-info">
                    <h3>Mermelada de Blueberry</h3>
                    <div class="product-footer">
                        <button class="add-cart-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39
                                        a2 2 0 0 0 2 1.61h9.72
                                        a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Ver más
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <h2 class="section-title">Otros</h2>
        <div class="products-grid">

            <div class="product-card">
                <img src="images/nueces_y_almendras.jpeg" alt="Pan Campesino">

                <div class="product-info">
                    <h3>Nueces y Almendras con Caramelo</h3>
                    <div class="product-footer">
                        <button class="add-cart-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39
                                        a2 2 0 0 0 2 1.61h9.72
                                        a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Ver más
                        </button>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <img src="images/tiavaca.jpeg" alt="Pan Campesino">

                <div class="product-info">
                    <h3>Tiavaca</h3>
                    <div class="product-footer">
                        <button class="add-cart-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39
                                        a2 2 0 0 0 2 1.61h9.72
                                        a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Ver más
                        </button>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <img src="images/granola_mix_masa_madre.jpeg" alt="Pan Campesino">

                <div class="product-info">
                    <h3>Granola Mix Masa Madre</h3>
                    <div class="product-footer">
                        <button class="add-cart-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39
                                        a2 2 0 0 0 2 1.61h9.72
                                        a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Ver más
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div id = "confirmModal" class = "modal">
        <div class = "modal-box">
            <p class = "modal-text">¿Estás seguro de que deseas salir?</p>
            <div class = "modal-buttons">
                <button id = "confirmExit">Sí</button>
                <button id = "cancelExit">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
        const userIconBtn = document.getElementById("userIconBtn");
        const userContent = document.getElementById("userContent");

        const exitButton = document.getElementById("exitButton");
        const modal = document.getElementById("confirmModal");
        const confirmExit = document.getElementById("confirmExit");
        const cancelExit = document.getElementById("cancelExit");

        userIconBtn.addEventListener("click", (e) => {
            e.preventDefault();
            userContent.classList.toggle("show");
        });

        exitButton.addEventListener("click", function (e) {
            e.preventDefault();
            modal.style.display = "flex";
        });

        cancelExit.addEventListener("click", function () {
            modal.style.display = "none";
        });

        confirmExit.addEventListener("click", function () {
            window.location.href = "index.php";
        });

        document.addEventListener("click", (e) => {
            if (!e.target.closest(".userContainer")) {
                userContent.classList.remove("show");
            }
        });
    </script>

</body>

</html>
