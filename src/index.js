import ControlCreate from './modules/control'

const { __ } = wp.i18n
const { registerPlugin } = wp.plugins
const { PluginDocumentSettingPanel } = wp.editPost
const { TextControl, TextareaControl } = wp.components
const { withSelect, withDispatch } = wp.data


/**
 * Title
 */

let TitleController = ControlCreate({
  component: TextControl,
  name: 'advertising_settings_advertisements_metafield'
})


/**
 * Description
 */

let Description = ControlCreate({
  component: TextareaControl,
  name: 'advertising_settings_commercial_content_type_metafield'
})


/**
 * Intro
 */

let Intro = ControlCreate({
  component: TextareaControl,
  name: 'advertising_settings_advertiser_name_metafield'
})


/**
 * Source
 */

let Source = ControlCreate({
  component: TextControl,
  name: 'source_meta'
})


/**
 * Register Plugin
 */

registerPlugin('ag-title-panel', {
  render: () => {
    return (
      <div>
        <PluginDocumentSettingPanel
          name='ag-title-desc-panel'
          title={ __( 'SEO Fields', 'agsf' ) }
        >
          <label>{ __( 'Title', 'agsf' ) }</label>
          <TitleController/>

          <label>{ __( 'Description', 'agsf' ) }</label>
          <Description/>
        </PluginDocumentSettingPanel>

        <PluginDocumentSettingPanel
          name='ag-intro-panel'
          title={ __( 'Introduction', 'agsf' ) }
        >
          <Intro/>
        </PluginDocumentSettingPanel>

        <PluginDocumentSettingPanel
          name='ag-source-panel'
          title={ __( 'Source', 'agsf' ) }
        >
          <Source/>
        </PluginDocumentSettingPanel>
      </div>
    )
  },
  icon: '',
})
