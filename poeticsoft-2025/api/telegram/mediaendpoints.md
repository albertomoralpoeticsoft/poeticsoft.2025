Endpoints para Mensajes de Texto y Medios con Texto
sendMessage: El método más básico para enviar un mensaje de texto.

Parámetros principales: chat_id, text, parse_mode.

sendPhoto: Para enviar fotos. Puedes incluir un texto (caption).

Parámetros principales: chat_id, photo, caption, parse_mode.

sendVideo: Para enviar videos. También permite un texto (caption).

Parámetros principales: chat_id, video, caption, parse_mode.

sendAudio: Para enviar archivos de audio (como música o podcasts) que se muestran en el reproductor de Telegram.

Parámetros principales: chat_id, audio, caption, performer, title.

sendVoice: Para enviar mensajes de voz (tipo grabadora).

Parámetros principales: chat_id, voice, caption.

sendDocument: Para enviar archivos generales (PDF, ZIP, etc.).

Parámetros principales: chat_id, document, caption.

sendAnimation: Para enviar archivos GIF o videos en bucle sin sonido.

Parámetros principales: chat_id, animation, caption.

Endpoints para Contenido Especial
sendSticker: Para enviar un sticker.

Parámetros principales: chat_id, sticker.

sendDice: Para enviar un dado animado.

Parámetros principales: chat_id, emoji (opcional, para seleccionar un tipo de dado, como 🎲, 🎯, etc.).

sendLocation: Para enviar una ubicación en el mapa.

Parámetros principales: chat_id, latitude, longitude.

sendVenue: Para enviar una ubicación con información de un lugar específico (nombre, dirección).

Parámetros principales: chat_id, latitude, longitude, title, address.

sendContact: Para enviar un contacto como si fuera una tarjeta vCard.

Parámetros principales: chat_id, phone_number, first_name.

sendPoll: Para crear y enviar una encuesta.

Parámetros principales: chat_id, question, options (una lista de opciones de respuesta).

Endpoints para Grupos de Medios (Álbumes)
sendMediaGroup: Este es un endpoint especial para enviar un álbum de fotos, videos o una combinación de ambos. En lugar de enviar un archivo a la vez, se envía un array de objetos de medios.

Parámetros principales: chat_id, media (un JSON-array con los objetos de medios, cada uno con type, media y caption).

Parámetros Comunes en Todos los Endpoints
Muchos de los endpoints anteriores comparten parámetros que te dan más control sobre cómo se envía el mensaje:

chat_id: Identificador del chat o canal.

disable_notification: true para enviar el mensaje sin sonido.

protect_content: true para evitar que el contenido sea reenviado o guardado.

reply_to_message_id: Para responder a un mensaje específico.

reply_markup: Para incluir un teclado inline o un teclado de respuesta personalizado.