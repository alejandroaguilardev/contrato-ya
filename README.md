# Contrato-Ya

Este proyecto es una aplicación web llamada **Contrato-Ya**, creada para facilitar la gestión de contratos y servicios. Está desarrollada utilizando tecnologías modernas para proporcionar una experiencia de usuario rápida y eficiente.

## Tecnologías Utilizadas

- **[Astro](https://astro.build/)**: Framework de desarrollo para crear sitios web estáticos, enfocado en mejorar la velocidad de carga y la experiencia del usuario. Permite combinar varias tecnologías de frontend.
- **[SCSS](https://sass-lang.com/)**: Extensión de CSS que permite utilizar variables, anidación y otras funcionalidades avanzadas para crear estilos más mantenibles.
- **pnpm**: Gestor de paquetes utilizado para manejar las dependencias del proyecto en el monorepo.
- **PHP**: Lenguaje utilizado para los servicios backend en el proyecto, facilitando la gestión de lógica del lado del servidor.
- **[Symfony](https://symfony.com/)**: Framework de PHP que se utiliza para construir APIs robustas y escalables en los servicios backend.

## Estructura del Proyecto

El proyecto sigue una estructura de monorepo para organizar el frontend y los servicios backend:

- **`packages/website/`**: Contiene el código del frontend construido con Astro. Aquí se implementan las vistas y componentes de la aplicación.
- **`packages/services/`**: Incluye los servicios backend.

## Instalación y Configuración

Para configurar el proyecto localmente, sigue estos pasos:

1. Clona el repositorio:

   ```bash
   git clone https://github.com/contrato-ya/website-project.git
   ```
2. Instalar las dependencias:

   ```bash
   pnpm install
   ```

3. Instalar las dependencias de website:
    cd package/website
   ```bash
   pnpm install
   ```

4. Instalar las dependencias  de los servicios:
    cd package/services/brevo-service
   ```bash
   composer install
   ```

## Licencia

Este proyecto está bajo la Licencia [Creative Commons Attribution-NonCommercial 4.0 International License](https://creativecommons.org/licenses/by-nc/4.0/). Esto significa que:

- Puedes compartir y adaptar el material, pero **no puedes usarlo con fines comerciales**.
- Debes dar crédito al creador, indicando que el contenido está basado en este proyecto.

Para más detalles, consulta el enlace de la licencia.
