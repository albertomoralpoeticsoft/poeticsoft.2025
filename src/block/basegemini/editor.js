const { __ } = wp.i18n
const { registerBlockType } = wp.blocks
const { 
  useBlockProps,
  RichText, 
  URLInputButton 
} = wp.blockEditor
const {
  Button
} = wp.components
import metadata from 'blocks/basegemini/block.json'
import './editor.scss'

const Edit = ({ attributes, setAttributes }) => {

  const blockProps = useBlockProps()
  const { 
    url, 
    context,
    userInit
  } = attributes

  return (
      <div {...blockProps}>
        <div className="url">
          {__('URL actual: ', 'poeticsoft')}
          <a href={url} target="_blank" rel="noopener noreferrer">{url}</a>
          <URLInputButton
            url={url}
            onChange={(newUrl, post) => setAttributes({ url: newUrl })}
          />
        </div>
        <RichText
          tagName="p"
          value={ context }
          onChange={(newContext) => setAttributes({ context: newContext })}
          placeholder={__('Context & Prompt', 'poeticsoft')}
        />
        <RichText
          tagName="p"
          value={ userInit }
          onChange={(newUserInit) => setAttributes({ userInit: newUserInit })}
          placeholder={__('Init message', 'poeticsoft')}
        />
      </div>
  )
}

registerBlockType(
  metadata.name,
  {
    edit: Edit,
    save: () => null
  }
)