const { withSelect, withDispatch } = wp.data


let ControlCreate = controlProps => {
  let controlName     = controlProps.name,
    // controlNameMeta = `_${controlName}`
    controlNameMeta = `${controlName}`

  let Control = props => {
    let ControlComponent = controlProps.component

    return <ControlComponent
      value={props[controlName]}
      onChange={(value) => props.onMetaFieldChange(value, controlName)}
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
      console.log('Dispatching');


      return {
        onMetaFieldChange: (value, controlName) => {
          console.log(`Meta field value ${value} for ${controlName}`);
          dispatch('core/editor').editPost({ meta: { [controlNameMeta]: value } })
        }
      }
    }
  )(Control)

  return Control
}

export default ControlCreate
