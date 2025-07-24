# Lista de bloques de WordPress (`<!-- wp:... -->`)

| Nombre del Bloque | Sintaxis HTML Comentario | Descripción | Atributos disponibles |
|-------------------|---------------------------|-------------|------------------------|
| `paragraph` | `<!-- wp:paragraph -->` | Párrafo de texto. | `align`, `placeholder`, `fontSize`, `textColor` |
| `heading` | `<!-- wp:heading -->` | Encabezado (h1, h2, etc.). | `level`, `align`, `fontSize`, `textColor` |
| `image` | `<!-- wp:image -->` | Imagen. | `url`, `alt`, `align`, `width`, `height`, `caption` |
| `cover` | `<!-- wp:cover -->` | Bloque de imagen/fondo con contenido. | `url`, `dimRatio`, `overlayColor`, `minHeight`, `align`, `focalPoint` |
| `columns` | `<!-- wp:columns -->` | Contenedor de múltiples columnas. | `align`, `verticalAlignment` |
| `column` | `<!-- wp:column -->` | Una columna dentro de `columns`. | `width`, `verticalAlignment` |
| `group` | `<!-- wp:group -->` | Contenedor genérico. | `layout`, `align`, `backgroundColor`, `textColor` |
| `template-part` | `<!-- wp:template-part {"slug":"header"} /-->` | Inserta una parte de plantilla. | `slug`, `theme`, `tagName` |
| `query` | `<!-- wp:query -->` | Loop de entradas. | `queryId`, `query`, `displayLayout`, `tagName` |
| `post-title` | `<!-- wp:post-title /-->` | Título de una entrada individual. | `isLink`, `textAlign`, `level` |
| `post-content` | `<!-- wp:post-content /-->` | Contenido de una entrada individual. | `layout`, `align` |
| `navigation` | `<!-- wp:navigation -->` | Menú de navegación. | `overlayMenu`, `orientation`, `layout` |
| `site-title` | `<!-- wp:site-title /-->` | Título del sitio. | `level`, `textAlign`, `isLink` |
| `site-tagline` | `<!-- wp:site-tagline /-->` | Lema del sitio. | `textAlign` |
| `site-logo` | `<!-- wp:site-logo /-->` | Logo del sitio. | `width`, `shouldSync` |
| `button` | `<!-- wp:button -->` | Botón de acción. | `textAlign`, `backgroundColor`, `textColor`, `width` |
| `buttons` | `<!-- wp:buttons -->` | Contenedor de botones. | `layout`, `align` |
| `spacer` | `<!-- wp:spacer -->` | Espacio vertical. | `height` |
| `separator` | `<!-- wp:separator -->` | Línea de separación. | `align`, `backgroundColor`, `className` |
| `list` | `<!-- wp:list -->` | Lista con viñetas o numerada. | `ordered`, `start`, `className` |
| `quote` | `<!-- wp:quote -->` | Cita textual. | `value`, `citation`, `align` |
| `audio` | `<!-- wp:audio -->` | Reproductor de audio. | `src`, `autoplay`, `loop` |
| `video` | `<!-- wp:video -->` | Reproductor de video. | `src`, `poster`, `autoplay`, `loop` |
| `file` | `<!-- wp:file -->` | Enlace a descarga de archivo. | `href`, `showDownloadButton`, `textLink` |