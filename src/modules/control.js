const { withSelect, withDispatch } = wp.data


let ControlCreate = controlProps => {
  let controlName     = controlProps.name,
    // controlNameMeta = `_${controlName}`
    controlNameMeta = `${controlName}`

  let Control = props => {
    let ControlComponent = controlProps.component

    return <ControlComponent
      value={props[controlName]}
      onChange={(value) => props.onMetaFieldChange(value)}
    />
  }

  Control = withSelect(
    (select) => {
      return {
        [controlName]: select('core/editor').getEditedPostAttribute('meta')[controlNameMeta]
      }
    }
  )(Control)

  Control = withDispatch(
    (dispatch) => {
      return {
        onMetaFieldChange: (value) => {
          dispatch('core/editor').editPost({ meta: { [controlNameMeta]: value } })
        }
      }
    }
  )(Control)

  return Control
}

export default ControlCreate
