/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */
/*  
wp.blocks.registerBlockType('brad/border-box', {
  title: 'Brid',
  icon: 'smiley',
  category: 'common',
  attributes: {
    content: {type: 'string'},
    color: {type: 'string'}
  },
  

  
  edit: function(props) {
    function updateContent(event) {
      props.setAttributes({content: event.target.value})
    }
    function updateColor(value) {
      props.setAttributes({color: value.hex})
    }
    
    return React.createElement(
      "div",
      null,
      React.createElement("div", {'class':'bridAjax cboxElement', 'id':'bridQuickPostIcon', 'href' : 'http://www.aljazeera.com/wordpress/wp-admin/admin-ajax.php?action=bridVideoLibrary'}, React.createElement(
    	'img',
    	{src:'http://www.aljazeera.com/wordpress/wp-content/plugins/brid-easy-video-publish//img/tv.svg', 'width':'40px'}
      ))
      //React.createElement("input", { type: "text", value: props.attributes.content, onChange: updateContent }),
      //React.createElement(wp.components.ColorPicker, { color: props.attributes.color, onChangeComplete: updateColor })
    );
  },
  save: function(props) {
    return wp.element.createElement(
      "h3",
      { style: { border: "3px solid " + props.attributes.color } },
      props.attributes.content
    );
  }
})
*/