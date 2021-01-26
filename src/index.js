console.log('loaded script');

import { registerPlugin } from "@wordpress/plugins";
import { PluginDocumentSettingPanel } from "@wordpress/edit-post";
 
const AdvertisingSettingsSideBarPanel = () => (
    <PluginDocumentSettingPanel
        name="advertising-settings"
        title="Advertising Settings"
        className="advertising-settings"
    >
      3 fields to go here as components wired to data store
    </PluginDocumentSettingPanel>
)
registerPlugin('advertising-settings-sidebar-panel', {
    render: AdvertisingSettingsSideBarPanel
})
