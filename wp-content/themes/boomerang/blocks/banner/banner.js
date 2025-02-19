import { registerBlockType } from '@wordpress/blocks';
import { RichText } from '@wordpress/block-editor';

registerBlockType('boomerang/banner', {
    title: 'Баннер',
    icon: 'megaphone',
    category: 'layout',
    attributes: {
        title: { type: 'string', source: 'html', selector: 'h2' },
        content: { type: 'string', source: 'html', selector: 'p' }
    },
    edit: ({ attributes, setAttributes }) => {
        return (
            <div class="boomerang-banner">
                <RichText
                    tagName="h2"
                    value={attributes.title}
                    onChange={(value) => setAttributes({ title: value })}
                    placeholder="Введите заголовок..."
                />
                <RichText
                    tagName="p"
                    value={attributes.content}
                    onChange={(value) => setAttributes({ content: value })}
                    placeholder="Введите текст..."
                />
            </div>
        );
    },
    save: ({ attributes }) => {
        return (
            <div class="boomerang-banner">
                <h2>{attributes.title}</h2>
                <p>{attributes.content}</p>
            </div>
        );
    }
});
