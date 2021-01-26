console.log( 'loaded script' );

import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import {
	ToggleControl,
	RadioControl,
	TextControl,
} from '@wordpress/components';
import { withState, compose } from '@wordpress/compose';
import { withSelect, withDispatch, dispatch, select } from '@wordpress/data';
import { Fragment } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';

domReady( function () {
	function updateHasAdvertising( newValue ) {
		console.log( `Setting new hasAdvertising value to: ${ newValue }` );
		dispatch( 'core/editor' ).editPost( {
			meta: { advertising_settings_advertisements_metafield: newValue },
		} );
	}

	function updateCommercialContentType( newValue ) {
		console.log(
			`Setting new CommercialContentType option to: ${ newValue }`
		);
		dispatch( 'core/editor' ).editPost( {
			meta: {
				advertising_settings_commercial_content_type_metafield: newValue,
			},
		} );
	}

	// function getCommercialContentType( ) {
	//   console.log( `Getting existing CommercialContentType option:`);
	//   let content_type = select('core/editor').getEditedPostAttribute('meta').advertising_settings_commercial_content_type_metafield
	//   console.log( content_type);
	//   return content_type;
	// }

	const AdvertisementsToggle = withState( {
		hasAdvertisements: true,
	} )( ( { hasAdvertisements, setState } ) => (
		<ToggleControl
			label="Fixed Background"
			help={
				hasAdvertisements ? 'Has advertisements.' : 'No advertisements.'
			}
			checked={ hasAdvertisements }
			onChange={ () => {
				updateHasAdvertising( ! hasAdvertisements );
				setState( ( state ) => ( {
					hasAdvertisements: ! state.hasAdvertisements,
				} ) );
			} }
		/>
	) );

	const CommercialContentType = withState( {
		option: 'none',
		// option: getCommercialContentType
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
			onChange={ ( option ) => {
				updateCommercialContentType( option );
				setState( ( state ) => ( { option } ) );
			} }
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

	function TestControl( { newValue, updateMeta } ) {
		return (
			<Fragment>
				<TextControl
					label={ 'Field One' }
					value={ newValue.one }
					onChange={ ( value ) => updateMeta( value ) }
				/>
				<TextControl
					label={ 'Field Two' }
					value={ newValue.two }
					onChange={ ( value ) => updateMeta( value ) }
				/>
			</Fragment>
		);
	}

	const FieldsTestControl = compose( [
		withSelect( () => {
			console.log( 'withSelect' );
			return 'something';
			// return {
			//     newValue: select( 'core/editor' ).getEditedPostAttribute( 'meta' )._metakey,
			// };
		} ),
		withDispatch( ( dispatch ) => ( {
			updateMeta( value ) {
				dispatch( 'core/editor' ).editPost( {
					meta: {
						_metakey: {
							one: value.one,
							two: value.two,
						},
					},
				} );
			},
		} ) ),
	] )( TestControl );

	const AdvertisingSettingsSideBarPanel = () => (
		<PluginDocumentSettingPanel
			name="advertising-settings"
			title="Advertising Settings"
			className="advertising-settings"
		>
			<FieldsTestControl />

			<AdvertisementsToggle
				checked={
					wp.data
						.select( 'core/editor' )
						.getEditedPostAttribute( 'meta' )
						.advertising_settings_advertisements_metafield
				}
			/>

			<CommercialContentType />

			<AdvertiserName />
		</PluginDocumentSettingPanel>
	);

	registerPlugin( 'advertising-settings-sidebar-panel', {
		render: AdvertisingSettingsSideBarPanel,
	} );
} );
