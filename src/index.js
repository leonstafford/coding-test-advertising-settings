console.log('loaded script');

import ControlCreate from './modules/control'

import { registerPlugin } from "@wordpress/plugins";
import { PluginDocumentSettingPanel } from "@wordpress/edit-post";
import { ToggleControl, RadioControl, TextControl } from '@wordpress/components';
import { withState } from '@wordpress/compose';

let AdvertisementsToggle = ControlCreate({
  component: ToggleControl,
  name: 'advertising_settings_advertisements'
})
 
let CommercialContentType = ControlCreate({
  component: RadioControl,
  name: 'advertising_settings_commercial_content'
})

let AdvertiserName = ControlCreate({
  component: TextControl,
  name: 'advertising_settings_advertiser_name'
})

const AdvertisingSettingsSideBarPanel = () => (
    <PluginDocumentSettingPanel
        name="advertising-settings"
        title="Advertising Settings"
        className="advertising-settings"
    >
      <label>{ 'Advertisements' }</label>
      <AdvertisementsToggle />

      <br/>
      <label>{ 'Commercial Content Type' }</label>
      <CommercialContentType/>

      <br/>
      <label>{ 'Advertiser Name' }</label>
      <AdvertiserName/>

    </PluginDocumentSettingPanel>
)
registerPlugin('advertising-settings-sidebar-panel', {
    render: AdvertisingSettingsSideBarPanel
})
