'use strict';

(function (blocks, element, components, editor, $) {
	var el = element.createElement,
		registerBlockType = blocks.registerBlockType,
		InspectorControls = editor.InspectorControls,
		ServerSideRender = components.ServerSideRender,
		RangeControl = components.RangeControl,
		Panel = components.Panel,
		PanelBody = components.PanelBody,
		PanelRow = components.PanelRow,
		TextControl = components.TextControl,
		//NumberControl = components.NumberControl,
		TextareaControl = components.TextareaControl,
		CheckboxControl = components.CheckboxControl,
		RadioControl = components.RadioControl,
		SelectControl = components.SelectControl,
		ToggleControl = components.ToggleControl,
		//ColorPicker = components.ColorPalette,
		//ColorPicker = components.ColorPicker,
		//ColorPicker = components.ColorIndicator,
		PanelColorPicker = editor.PanelColorSettings,
		DateTimePicker = components.DateTimePicker;



	registerBlockType('codeboxr/codeboxrflexiblecountdown', {
        title: cbfc_block.block_title,
        icon: 'backup',
        category: cbfc_block.block_category,

        /*
         * In most other blocks, you'd see an 'attributes' property being defined here.
         * We've defined attributes in the PHP, that information is automatically sent
         * to the block editor, so we don't need to redefine it here.
         */
        edit: function (props) {

        	var pro_html = '';

        	if(cbfc_block.pro){

        		pro_html = el( PanelBody, { title: cbfc_block.cbfc_pro_settings.title, initialOpen: false },
									el( SelectControl,
										{
											label: cbfc_block.cbfc_pro_settings.plugin,
											options : cbfc_block.cbfc_pro_settings.plugin_options,
											onChange: ( value ) => {
												props.setAttributes( { plugin: value } );
											},
											value: props.attributes.plugin
										}
									),
									el( TextControl,
										{
											label: cbfc_block.cbfc_pro_settings.id,
											onChange: ( value ) => {
												props.setAttributes( { id: value } );
											},
											value: props.attributes.id
										}
									),
									el( TextControl,
										{
											label: cbfc_block.cbfc_pro_settings.category,
											onChange: ( value ) => {
												props.setAttributes( { category: value } );
											},
											value: props.attributes.category
										}
									),

							);


			}//end if pro


            return [
                /*
                 * The ServerSideRender element uses the REST API to automatically call
                 * php_block_render() in your PHP code whenever it needs to get an updated
                 * view of the block.
                 */
                el(ServerSideRender, {
                    block: 'codeboxr/codeboxrflexiblecountdown',
                    attributes: props.attributes,
                }),


				el( InspectorControls, {},
					// 1st Panel – Form Settings
					el( PanelBody, { title: cbfc_block.cbfc_general_settings.title, initialOpen: true },
						el( SelectControl,
							{
								label: cbfc_block.cbfc_general_settings.type,
								options : cbfc_block.cbfc_general_settings.type_options,
								onChange: ( value ) => {
									props.setAttributes( { type: value } );
								},
								value: props.attributes.type
							}
						),
						el( DateTimePicker,
							{
								label: cbfc_block.cbfc_general_settings.date,
								onChange: ( value ) => {
									props.setAttributes( { date: value } );
								},
								value: props.attributes.date
							}
						),
						el( ToggleControl,
							{
								label: cbfc_block.cbfc_general_settings.hide_sec,
								onChange: ( value ) => {
									props.setAttributes( { hide_sec: value } );
								},
								checked: props.attributes.hide_sec
							}
						),
					),
					el( PanelBody, { title: cbfc_block.cbfc_light_settings.title, initialOpen: false },

						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_light_settings.l_numclr,
								initialOpen: false,
								colorSettings : [
									{
										label: cbfc_block.cbfc_light_settings.l_numclr,
										value: props.attributes.l_numclr,
										onChange: ( value ) => {
											props.setAttributes( { l_numclr: value } );
										},
									},
								],
							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_light_settings.l_resnumclr,
								initialOpen: false,
								colorSettings : [
									{
										label: cbfc_block.cbfc_light_settings.l_resnumclr,
										value: props.attributes.l_resnumclr,
										onChange: ( value ) => {
											props.setAttributes( { l_resnumclr: value } );
										},
									},
								],
							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_light_settings.l_numbgclr,
								initialOpen: false,
								colorSettings : [
									{
										label: cbfc_block.cbfc_light_settings.l_numbgclr,
										value: props.attributes.l_numbgclr,
										onChange: ( value ) => {
											props.setAttributes( { l_numbgclr: value } );
										},
									},
								],
							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_light_settings.l_textclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.l_textclr,
										label: cbfc_block.cbfc_light_settings.l_textclr,
										onChange: ( value ) => {
											props.setAttributes( { l_textclr: value } );
										},
									},
								],

							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_light_settings.l_restextclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.l_restextclr,
										label: cbfc_block.cbfc_light_settings.l_restextclr,
										onChange: ( value ) => {
											props.setAttributes( { l_restextclr: value } );
										},
									},
								]
							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_light_settings.l_textbgclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.l_textbgclr,
										label: cbfc_block.cbfc_light_settings.l_textbgclr,
										onChange: ( value ) => {
											props.setAttributes( { l_textbgclr: value } );
										},
									},
								]

							}
						),

					),
					el( PanelBody, { title: cbfc_block.cbfc_circular_settings.title, initialOpen: false },
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_circular_settings.c_secbclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.c_secbclr,
										label: cbfc_block.cbfc_circular_settings.c_secbclr,
										onChange: ( value ) => {
											props.setAttributes( { c_secbclr: value } );
										},
									},
								]
							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_circular_settings.c_minbclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.c_minbclr,
										label: cbfc_block.cbfc_circular_settings.c_minbclr,
										onChange: ( value ) => {
											props.setAttributes( { c_minbclr: value } );
										},
									},
								]

							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_circular_settings.c_hourbclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.c_hourbclr,
										label: cbfc_block.cbfc_circular_settings.c_hourbclr,
										onChange: ( value ) => {
											props.setAttributes( { c_hourbclr: value } );
										},
									},
								]

							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_circular_settings.c_daybclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.c_daybclr,
										label: cbfc_block.cbfc_circular_settings.c_daybclr,
										onChange: ( value ) => {
											props.setAttributes( { c_daybclr: value } );
										},
									},
								]

							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_circular_settings.c_bgclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.c_bgclr,
										label: cbfc_block.cbfc_circular_settings.c_bgclr,
										onChange: ( value ) => {
											props.setAttributes( { c_bgclr: value } );
										},
									},
								]
							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_circular_settings.c_textclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.c_textclr,
										label: cbfc_block.cbfc_circular_settings.c_textclr,
										onChange: ( value ) => {
											props.setAttributes( { c_textclr: value } );
										},
									},
								]
							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_circular_settings.c_restextclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.c_restextclr,
										label: cbfc_block.cbfc_circular_settings.c_restextclr,
										onChange: ( value ) => {
											props.setAttributes( { c_restextclr: value } );
										},
									},
								]
							}
						),
						el( TextControl,
							{
								label: cbfc_block.cbfc_circular_settings.c_borderw,
								onChange: ( value ) => {
									props.setAttributes( { c_borderw: parseInt(value) } );
								},
								value: props.attributes.c_borderw,
								type: 'number'
							}
						),

					),
					el( PanelBody, { title: cbfc_block.cbfc_kk_settings.title, initialOpen: false },
						el( TextControl,
							{
								label: cbfc_block.cbfc_kk_settings.kk_fontsize,
								onChange: ( value ) => {
									props.setAttributes( { kk_fontsize: value } );
								},
								value: props.attributes.kk_fontsize
							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_kk_settings.kk_numclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.kk_numclr,
										label: cbfc_block.cbfc_kk_settings.kk_numclr,
										onChange: ( value ) => {
											props.setAttributes( { kk_numclr: value } );
										},
									},
								]
							}
						),
						el( PanelColorPicker,
							{
								title: cbfc_block.cbfc_kk_settings.kk_textclr,
								initialOpen: false,
								colorSettings : [
									{
										value: props.attributes.kk_textclr,
										label: cbfc_block.cbfc_kk_settings.kk_textclr,
										onChange: ( value ) => {
											props.setAttributes( { kk_textclr: value } );
										},
									},
								]

							}
						),
					),
					pro_html
				)



        ]},
        // We're going to be rendering in PHP, so save() can just return null.
        save: function () {
            return null;
        },
    });
}(
    window.wp.blocks,
    window.wp.element,
    window.wp.components,
    window.wp.editor
));