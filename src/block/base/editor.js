const { __ } = wp.i18n
const { registerBlockType } = wp.blocks
const { useBlockProps } = wp.blockEditor
import metadata from 'blocks/base/block.json'
import './editor.scss';

const Edit = props => {

  const blockProps = useBlockProps()

  return <div { ...blockProps }>
    EDIT
  </div>
}

const Save = props => {

  const blockProps = useBlockProps.save()

  return <div { ...blockProps }>
    SAVE
  </div>
}

registerBlockType(
  metadata.name,
  {
    edit: Edit,
    save: Save
  }
)