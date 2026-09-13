<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCheck - Bienvenidos</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/landing.css') ?>">
</head>
<body>

    <!-- Header / Navbar Superior -->
    <header class="navbar">
        <div class="logo-container">
            <img src="<?= base_url('assets/imagenes/logo_naranja.png') ?>" alt="NutriCheck Logo" class="nav-logo">
        </div>
        <nav class="nav-links">
            <a href="#sobre-nosotros">SOBRE NOSOTROS</a>
            <a href="#herramientas">HERRAMIENTAS</a>
            <a href="#asesores">ASESORES</a>
            <a href="#desarrolladores">DESARROLLADORES</a>
        </nav>
    </header>

    <!-- Contenedor Principal (Hero Section) -->
    <main class="hero-container">
        <div class="hero-content">
            <div class="left-section">
                <img src="<?= base_url('assets/imagenes/fraseinicio.png') ?>" alt="Pequeños cambios, grandes resultados" class="img-frase">
                <div class="btn-group">
                    <a href="<?= base_url('login') ?>" class="btn btn-login">Iniciar sesión</a>
                    <a href="<?= base_url('register') ?>" class="btn btn-register">Crear cuenta</a>
                </div>
            </div>
            <div class="right-section">
                <img src="<?= base_url('assets/imagenes/preingreso.png') ?>" alt="Collage NutriCheck" class="img-hero">
            </div>
        </div>
    </main>

    <!-- Sección Sobre Nosotros -->
    <section id="sobre-nosotros" class="about-section">
        <div class="cards-container">
            <div class="info-card">
                <img src="<?= base_url('assets/imagenes/iconmision.png') ?>" alt="Ícono Misión" class="card-icon">
                <h2>MISIÓN</h2>
                <p>Empoderar a los usuarios en el control de su salud mediante herramientas de planificación aprobadas por especialistas, fomentando hábitos saludables y un seguimiento consciente.</p>
            </div>
            <div class="info-card">
                <img src="<?= base_url('assets/imagenes/iconvision.png') ?>" alt="Ícono Visión" class="card-icon">
                <h2>VISIÓN</h2>
                <p>Ser la plataforma de referencia en planificación nutricional, facilitando el seguimiento de los hábitos del usuario y optimizando la consulta con su especialista.</p>
            </div>
            <div class="info-card">
                <img src="<?= base_url('assets/imagenes/iconobjetivos.png') ?>" alt="Ícono Objetivos" class="card-icon">
                <h2>OBJETIVOS</h2>
                <ul>
                    <li>Evaluar condición física con la calculadora IMC.</li>
                    <li>Facilitar recetas adaptadas al perfil del usuario.</li>
                    <li>Organizar los datos de alimentación para la consulta profesional.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Sección Herramientas (Carrusel) -->
    <section id="herramientas" class="tools-section">
        <div class="carousel-container">
            <img src="<?= base_url('assets/imagenes/iconflechaizquierda.png') ?>" alt="Anterior" id="prevBtn" class="carousel-arrow">
            <div class="carousel-wrapper">
                <div class="carousel-track">
                    <div class="tool-item">
                        <img src="<?= base_url('assets/imagenes/iconcalculadora.png') ?>" alt="Calculadora IMC">
                        <h3>CALCULADORA<br>IMC</h3>
                    </div>
                    <div class="tool-item">
                        <img src="<?= base_url('assets/imagenes/iconregistro.png') ?>" alt="Registro de Comidas">
                        <h3>REGISTRO DE<br>COMIDAS</h3>
                    </div>
                    <div class="tool-item">
                        <img src="<?= base_url('assets/imagenes/iconusuario.png') ?>" alt="Perfil Clínico">
                        <h3>PERFIL<br>CLÍNICO</h3>
                    </div>
                    <div class="tool-item">
                        <img src="<?= base_url('assets/imagenes/iconlupa.png') ?>" alt="Buscador de Recetas">
                        <h3>BUSCADOR<br>DE RECETAS</h3>
                    </div>
                </div>
            </div>
            <img src="<?= base_url('assets/imagenes/iconflechaderecha.png') ?>" alt="Siguiente" id="nextBtn" class="carousel-arrow">
        </div>
    </section>

<!-- Sección Asesores -->
    <section id="asesores" class="asesores-section">
        <h2 class="section-title">ASESORES</h2>
        <div class="asesores-grid">
            <div class="asesor-card">
                <img src="<?= base_url('assets/imagenes/foto_provesalud.jpg') ?>" alt="Centro Médico Provesalud" class="asesor-img">
                <div class="asesor-text">
                    <h3>CENTRO MÉDICO PROVESALUD</h3>
                    <p>Por facilitar el acompañamiento del especialista en nutrición y aportar asesoría a nivel empresarial.</p>
                </div>
            </div>
            <div class="asesor-card">
                <img src="<?= base_url('assets/imagenes/foto_nutri.jpg') ?>" alt="Dr. María de los Ángeles" class="asesor-img">
                <div class="asesor-text">
                    <h3>DR. MARÍA DE LOS ÁNGELES</h3>
                    <p>Contribuyó a validar nuestras herramientas, mejorar su funcionalidad y orientar la visión nutricional del proyecto.</p>
                </div>
            </div>
                <div class="asesor-card">
                <img src="<?= base_url('assets/imagenes/foto_umc.jpg') ?>" alt="Universidad Marítima del Caribe" class="asesor-img">
                <div class="asesor-text">
                    <h3>UNIVERSIDAD MARÍTIMA DEL CARIBE</h3>
                    <p>Nos brindó los espacios y conocimientos necesarios para llevar este proyecto a la realidad.</p>
                </div>
            </div>
            <div class="asesor-card">
                <img src="<?= base_url('assets/imagenes/foto_bari.jpg') ?>" alt="Estudiantes del Inst. Gastronómico del Litoral" class="asesor-img">
                <div class="asesor-text">
                    <h3>ESTUDIANTES DEL INST. GASTRONÓMICO DEL LITORAL</h3>
                    <p>Contribuyeron con sus conocimientos y experiencia en la elaboración de recetas adaptadas a la realidad del estado La Guaira.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer / Sección Desarrolladores -->
    <footer id="desarrolladores" class="footer-section">
        <div class="footer-container">
            <div class="footer-col">
                <h4>PROGRAMACIÓN 3</h4>
                <p>NutriCheck es un prototipo funcional desarrollado exclusivamente con fines académicos.</p>
            </div>
            <div class="footer-col">
                <h4>ESTUDIANTES</h4>
                <p>Amaranta Montaño<br>Maxwell Cordero<br>Albaro Acosta<br>Jean Paul Salazar</p>
            </div>
            <div class="footer-col">
                <h4>LABORES</h4>
                <p>Frontend<br>Backend<br>DBA<br>Liderazgo</p>
            </div>
            <div class="footer-col">
                <h4>CONTACTO</h4>
                <p>nutricheck@gmail.com</p>
            </div>
        </div>
    </footer>

    <script>
        const track = document.querySelector('.carousel-track');
        const items = document.querySelectorAll('.tool-item');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        let currentIndex = 0;

        function updateCarousel() {
            items.forEach((item, index) => {
                item.classList.remove('active', 'side');
                if (index === currentIndex) {
                    item.classList.add('active');
                } else {
                    item.classList.add('side');
                }
            });

            const offset = -currentIndex * 230; 
            track.style.transform = `translateX(${offset}px)`;
        }

        nextBtn.addEventListener('click', () => {
            if (currentIndex < items.length - 1) {
                currentIndex++;
            } else {
                currentIndex = 0;
            }
            updateCarousel();
        });

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
            } else {
                currentIndex = items.length - 1;
            }
            updateCarousel();
        });

        updateCarousel();
    </script>

</body>
</html>