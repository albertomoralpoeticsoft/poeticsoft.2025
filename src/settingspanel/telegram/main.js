import moment from 'moment'
moment.locale('es');
const { 
  registerPlugin 
} = wp.plugins
const { 
  PluginDocumentSettingPanel 
} = wp.editPost
const { 
  useEntityProp 
} = wp.coreData
const { 
  SelectControl, 
  CheckboxControl, 
  Button 
} = wp.components
const { 
  useState,
  useEffect
} = wp.element
const { 
  useDispatch 
} = wp.data

import './main.scss'

const PoeticsoftPostSettingsTelegram = () => {

  const dispatch = useDispatch()

	const postType = wp.data
  .select('core/editor')
  .getCurrentPostType()

	if (postType !== 'post') {

		return null
	}

  const postId = wp.data
  .select('core/editor')
  .getCurrentPostId();
  const postStatus = wp.data
  .select('core/editor')
  .getEditedPostAttribute('status')
  const postDate = wp.data
  .select('core/editor')
  .getEditedPostAttribute('date')
  const postDateHuman = moment(postDate).fromNow()
  const [ destinations, setDestinations ] = useState([])
  const [ publishing, setPublishing ] = useState(false)
  const [ message, setMessage ] = useState('')
  const [ meta, setMeta ] = useEntityProp(
    'postType', 
    'post', 
    'meta'
  )

	const publish = () => {

		setPublishing(true)
    setMessage('publicando...')

    fetch(`/wp-json/poeticsoft/telegram/publishwp?type=post&postid=${ postId }`)
    .then(
      result => result
      .json()
      .then(
        published => {

          if(published.ok) {
            setMeta({

              ...meta,
              poeticsoft_post_publish_telegram_lastpublishdate: published.publishdate
            })

            setMessage('')

          } else {

            setMessage(published.description)
          }

          setPublishing(false)
        }
      )
    )
	}

  const publishActivate = state => {
    
    setMeta({
      ...meta,
      poeticsoft_post_publish_telegram_active: state
    })
  }

  const publishOnChangeActivate = state => {

    if(!state) {

      fetch(`/wp-json/poeticsoft/telegram/disableonchange?postid=${ postId }`)
      .then(
        result => result
        .json()
        .then(
          disabled => {

            console.log(disabled)
          }
        )
      )
    }
    
    setMeta({
      ...meta,
      poeticsoft_post_publish_telegram_publishonchange: state
    })
  }

  const changeDestination = destination => {
    
    setMeta({
      ...meta,
      poeticsoft_post_publish_telegram_destination: destination
    })
  }

  useEffect(() => {

    fetch('/wp-json/poeticsoft/telegram/destinationlist')
    .then(
      result => result
      .json()
      .then(
        list => {

          if(!meta.poeticsoft_post_publish_telegram_destination) {

            const defaultoption = list.find(o => o.default)

            setMeta({
              ...meta,
              poeticsoft_post_publish_telegram_destination: defaultoption.value
            })
          }
          
          setDestinations(list)
        }
      )
    )
  }, [])

	return <PluginDocumentSettingPanel
    name="poeticsoft-post-settings-telegram"
    title="TELEGRAM"
    className="poeticsoft-post-settings-telegram"
  >
    <div className="Settings">
      {
        meta.poeticsoft_post_publish_telegram_lastpublishdate &&
        <div className="LastPublishDate">
          <span className="Text">PUBLICADO:</span>
          { ' ' }
          <span className="Date">
            { 
              moment(meta.poeticsoft_post_publish_telegram_lastpublishdate)
              .format('L-LTS') 
            }
          </span>
        </div>
      }
      <CheckboxControl
        label="Publicar"
        help={
          meta.poeticsoft_post_publish_telegram_active ?
            postStatus != 'publish' ?
            `Se publicará en Telegram cuando se publique la página, programada para ${ postDateHuman }...`
            :
            "Selecciona \"Publicar ahora\" para publicar en Telegram"
          :
          ''
        }
        checked={ meta.poeticsoft_post_publish_telegram_active }
        onChange={  publishActivate }
      />
      <CheckboxControl
        label="Republicar"
        help="Volver a publicar si hay cambios."
        disabled={ !meta.poeticsoft_post_publish_telegram_active }
        checked={ meta.poeticsoft_post_publish_telegram_publishonchange }
        onChange={  publishOnChangeActivate }
      />
      <SelectControl
        label="Publicar en"
        disabled={ !meta.poeticsoft_post_publish_telegram_active }
        value={ meta.poeticsoft_post_publish_telegram_destination }
        options={ destinations }
        onChange={ changeDestination }
      />
      <Button
        variant="primary"
        disabled={ 
          !meta.poeticsoft_post_publish_telegram_active
          ||
          publishing
        }
        onClick={ publish }
      >
        Publicar ahora
      </Button>
      <div className="Message">
        {
          message != '' &&
          message
        }
      </div>
    </div>
  </PluginDocumentSettingPanel>
}

registerPlugin(
  'poeticsoft-post-settings-telegram', 
  {
	  render: PoeticsoftPostSettingsTelegram,
    icon: null,
  }
)