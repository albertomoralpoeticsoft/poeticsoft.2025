<?php
/**
 * Server-side render for the "block-base" block.
 *
 * @param array $attributes Los atributos del bloque desde JS.
 * @param string $content El contenido interno del bloque (no se usa normalmente en bloques dinámicos).
 * @return string HTML renderizado.
 */

function poeticsoft_render_block_base( $attributes, $content ) {

    // Puedes acceder a los atributos definidos en block.json
    $text = isset($attributes['exampleText']) ?
    esc_html($attributes['exampleText']) 
    : 
    'Texto por defecto';

    // Agrega clases y atributos del editor con useBlockProps.save()
    $wrapper_attributes = get_block_wrapper_attributes();

    return sprintf(
        '<div %s>%s</div>',
        $wrapper_attributes,
        $text
    );
}

echo poeticsoft_render_block_base( $attributes, $content );