import './admin.scss';

const poeticsoftMediaPublishTelegram = ($, postid) => {

  const $MediaPublishTelegram = $('.poeticsoft-media-publish-telegram')
  if($MediaPublishTelegram.length) {

    $MediaPublishTelegram
    .each(function() {

      const $this = $(this)
      const $selectchannel = $this.find('.selectchannel')
      const $publish = $this.find('.publish')

      fetch('/wp-json/poeticsoft/telegram/destinationlist')
      .then(
        result => result
        .json()
        .then(
          list => {

            const options = list
            .map(o => `<option value="${ o.value }" ${ o.default ? 'selected' : '' }>${ o.label }</option>`)
            .join('')

            $selectchannel.html(options)
          }
        )
      )

      $publish.on(
        'click',
        function() {

          const $this = $(this)
          const destination = $selectchannel.val()

          $this.prop("disabled", true)
          $publish.html('Publicando...')

          fetch(`/wp-json/poeticsoft/telegram/publishwp?type=media&destination=${ destination }&postid=${ postid }`)
          .then(
            result => result
            .json()
            .then(
              published => {

                console.log(published)

                $this.prop("disabled", false)
                $publish.html('Publicar')
              }
            )
          )
        }
      )
    })
  }
}

window.poeticsoftMediaPublishTelegram = postid => {

  poeticsoftMediaPublishTelegram(jQuery, postid)
}