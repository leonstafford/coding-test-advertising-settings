console.log('loaded script');

import { registerPlugin } from "@wordpress/plugins";
import { PluginDocumentSettingPanel } from "@wordpress/edit-post";
import { ToggleControl, RadioControl, TextControl } from '@wordpress/components';
import { withState } from '@wordpress/compose';
import { withSelect } from '@wordpress/data';

const AdvertisementsToggle = withState( {
  hasAdvertisements: true,
} )( ( { hasAdvertisements, setState } ) => (
  <ToggleControl
    label="Fixed Background"
    help={ hasAdvertisements ? 'Has advertisements.' : 'No advertisements.' }
    checked={ hasAdvertisements }
    onChange={ () => setState( ( state ) => ( { hasAdvertisements: ! state.hasAdvertisements } ) ) }
  />
) );
 
const CommercialContentType = withState( {
  option: 'none', initialState: 'none'
} )( ( { option, setState } ) => (
  <RadioControl
    label="Commercial Content Type"
    help="The type of advertising."
    selected={ option }
    options={ [
      { label: 'None', value: 'none' },
      { label: 'Sponsored content', value: 'sponsored_content' },
      { label: 'Partnered content', value: 'partnered_content' },
      { label: 'Brought to you by', value: 'brought_to_you_by' },
    ] }
    onChange={ ( option ) => { setState( { option } ) } }
  />
) );

const AdvertiserName = withState( {
    advertiserName: '',
} )( ( { advertiserName, setState } ) => ( 
    <TextControl
        label="Advertiser's Name"
        value={ advertiserName }
        onChange={ ( advertiserName ) => setState( { advertiserName } ) }
    />
) );

const AdvertisingSettingsSideBarPanel = () => (
    <PluginDocumentSettingPanel
        name="advertising-settings"
        title="Advertising Settings"
        className="advertising-settings"
    >
      <AdvertisementsToggle />

      <CommercialContentType />

      <AdvertiserName />

    </PluginDocumentSettingPanel>
)
registerPlugin('advertising-settings-sidebar-panel', {
    render: AdvertisingSettingsSideBarPanel
})
