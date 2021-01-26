console.log('loaded script');

const { registerPlugin } = wp.plugins
const { PluginDocumentSettingPanel } = wp.editPost
 
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
