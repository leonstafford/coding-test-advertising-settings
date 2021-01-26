const { withSelect, withDispatch } = wp.data

let ControlCreate = controlProps => {
  let controlName     = controlProps.name,
    controlNameMeta = `${controlName}`

  let Control = props => {
    let ControlComponent = controlProps.component

    // conditionally set attributes based on type
    if (controlProps.name === 'advertising_settings_advertisements_metafield') {
      return <ControlComponent
        value={props[controlName]}
        checked={ props[controlName] }
        onChange={(value) => props.onMetaFieldChange(! props[controlName], controlName)}
      />
    } else if (controlProps.name === 'advertising_settings_commercial_content_type_metafield') {
      return <ControlComponent
        value={props[controlName]}
        selected={ props[controlName] }
        options={ [
          { label: 'None', value: 'none' },
          { label: 'Sponsored content', value: 'sponsored_content' },
          { label: 'Partnered content', value: 'partnered_content' },
          { label: 'Brought to you by', value: 'brought_to_you_by' },
        ] }
        onChange={(value) => props.onMetaFieldChange(value, controlName)}
      />
    } else if (controlProps.name === 'advertising_settings_advertiser_name_metafield') {
      return <ControlComponent
        value={props[controlName]}
        onChange={(value) => props.onMetaFieldChange(value, controlName)}
      />
    }
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
        onMetaFieldChange: (value, controlName) => {
          if (controlName === 'advertising_settings_advertisements_metafield') {
            dispatch('core/editor').editPost({ meta: { [controlNameMeta]: value} })
          } else {
            dispatch('core/editor').editPost({ meta: { [controlNameMeta]: value } })

          }

        }
      }
    }
  )(Control)

  return Control
}

export default ControlCreate
