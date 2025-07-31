const { __ } = wp.i18n
const { 
  registerBlockType
} = wp.blocks
const { 
  useBlockProps,
  RichText,
  InnerBlocks
} = wp.blockEditor
const { 
  TextControl,
  TextareaControl,
  Button
} = wp.components
import metadata from 'blocks/assistant/block.json'
import './editor.scss';

const Edit = props => {

  const blockProps = useBlockProps()

  const allowedblocks = [
    'core/heading',
    'core/paragraph',
    'core/list',
    'core/list-item'
  ]

  return <div { ...blockProps }>
    <div className="PrePrompt">
      <TextareaControl
        label="Pre Prompt"
        value={ props.attributes.preprompt }
        onChange={ 
          newValue => props.setAttributes({ 
            preprompt: newValue 
          }) 
        }
        help="Texto de ayuda para el usuario."
        rows="5"
        placeholder="Información sobre la doc que vamos a proporcionar..."
      />
    </div>
    <div className="Context">
      <div className="Label">
        Documentación total sobre el tema
      </div>
      <div className="Content">
        <InnerBlocks
          allowedBlocks={ allowedblocks }
        />
      </div>
    </div>
    <div className="Prompt">
      <TextareaControl
        label="Prompt"
        value={ props.attributes.prompt }
        onChange={ 
          newValue => props.setAttributes({ 
            prompt: newValue 
          }) 
        }
        help="Texto de ayuda para el usuario."
        rows="5"
        placeholder="Información sobre lo que esperamos que haga el asistente..."
      />
    </div>
  </div>
}

registerBlockType(
  metadata.name,
  {
    edit: Edit,
    save: () => null
  }
)