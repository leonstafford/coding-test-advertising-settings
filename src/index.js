import ControlCreate from './modules/control'

const { __ } = wp.i18n
const { registerPlugin } = wp.plugins
const { PluginDocumentSettingPanel } = wp.editPost
const { TextControl, ToggleControl, RadioControl } = wp.components
const { withSelect, withDispatch } = wp.data

let Advertisements = ControlCreate({
  component: ToggleControl,
  name: 'advertising_settings_advertisements_metafield'
})

let ContentType = ControlCreate({
  component: RadioControl,
  name: 'advertising_settings_commercial_content_type_metafield'
})

let AdvertiserName = ControlCreate({
  component: TextControl,
  name: 'advertising_settings_advertiser_name_metafield'
})

/**
 * Register Plugin
 */
registerPlugin('advertising-settings-panel', {
  render: () => {
    return (
      <div>
        <PluginDocumentSettingPanel
          name='advertising-settings-panel'
          title={ 'Advertising Settings' }
        >
          <label>{ 'Advertisements' }</label>
          <Advertisements/>

          <label>{ 'Commercial Content Type' }</label>
          <ContentType />

          <label>{ 'Advertiser Name' }</label>
          <AdvertiserName/>
        </PluginDocumentSettingPanel>

      </div>
    )
  },
  icon: '',
})
