<p align="center">
  <img src="public/assets/imagenes/logo_naranja.png" alt="Logo NutriCheck" width="260">
</p>

<h1 align="center">NutriCheck</h1>

<p align="center">
  <strong>Plataforma web de planificación nutricional y seguimiento de hábitos saludables</strong><br>
  Proyecto académico desarrollado para la asignatura <em>Programación 3</em> — Universidad Marítima del Caribe (UMC).
</p>

<p align="center">
  <a href="https://test-nutri.infinityfreeapp.com/" target="_blank">Ver versión desplegada (Demo)</a>
</p>

---

## Descripción del Proyecto

**NutriCheck** es un prototipo web desarrollado con fines académicos que facilita a los usuarios el monitoreo de sus hábitos alimenticios y su evaluación física, a la vez que organiza información útil para el acompañamiento con especialistas en nutrición.

La plataforma permite evaluar indicadores antropométricos, consultar recetas adaptadas a condiciones médicas o alergias, registrar el historial diario de comidas y acceder a contenido informativo validado por profesionales.

---

## Funcionalidades Principales

* **Calculadora de Evaluación Física (IMC, Cintura e ICE):** Calcula el Índice de Masa Corporal, el rango de peso saludable estimado, el riesgo por perímetro abdominal y el Índice Cintura-Estatura bajo referencias OMS y NICE, ofreciendo recomendaciones personalizadas.
* **Buscador de Recetas:** Permite explorar recetas saludables y filtrar resultados considerando ingredientes y el perfil clínico del usuario.
* **Creador y Gestor de Recetas:** Panel exclusivo para administradores y nutricionistas para registrar recetas, ingredientes y etiquetas nutricionales, con flujo de aprobación antes de su publicación.
* **Racha de Comidas:** Registro diario de comidas (desayuno, almuerzo, cena y merienda) con calendario interactivo, historial editable y opción de cargar foto del plato.
* **Perfil Clínico:** Administración de datos personales, medidas corporales y catálogo de patologías y alergias.
* **Noticias (Newspaper):** Espacio informativo de salud, jornadas médicas y recetas especiales con categorías, guardado de artículos y moderación de publicaciones.
* **Suscripción NutriCheckPro y Notificaciones:** Flujo de reporte y validación de pagos (Pago Móvil y Zelle), notificaciones internas por rol y rotación de banners publicitarios para cuentas gratuitas.

---

## Roles de Usuario

| Rol | Alcance dentro del sistema |
| :--- | :--- |
| **Administrador (`admin`)** | Control total de la plataforma: aprobación de recetas, noticias y pagos, gestión de banners publicitarios y catálogo clínico. |
| **Nutricionista (`nutricionista`)** | Creación de recetas, ingredientes, etiquetas y artículos en Noticias (sujetos a aprobación del administrador). |
| **Usuario Premium (`premium`)** | Acceso completo a todas las herramientas sin anuncios publicitarios, incluyendo la sección de Noticias. |
| **Usuario Gratuito (`free`)** | Acceso a Calculadora IMC, Buscador de Recetas, Racha de Comidas y Perfil Clínico con anuncios integrados. |

---

## Tecnologías Utilizadas

* **Backend:** PHP 8.2 y CodeIgniter 4
* **Base de datos:** MySQL (driver MySQLi)
* **Frontend:** HTML5, CSS3, Bootstrap y JavaScript
* **Entorno local y despliegue:** XAMPP, Composer e InfinityFree

---

## Instalación y Ejecución Local

### Requisitos previos
* PHP 8.2 o superior (recomendado mediante **XAMPP**)
* **MySQL**
* **Composer**

### Pasos de configuración

1. **Clonar el repositorio** dentro de la carpeta `htdocs` de XAMPP:
   ```bash
   git clone [https://github.com/USUARIO/REPOSITORIO.git](https://github.com/USUARIO/REPOSITORIO.git) nutricheck
   cd nutricheck
