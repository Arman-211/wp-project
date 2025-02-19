const { registerBlockType } = wp.blocks;
const { MediaUpload, RichText, InspectorControls } = wp.blockEditor;
const { Button, PanelBody, TextControl } = wp.components;
const { __ } = wp.i18n;

registerBlockType("custom/gutslider", {
    title: __("Custom GutSlider"),
    icon: "images-alt",
    category: "design",
    attributes: {
        imageUrl: { type: "string", default: "" },
        title: { type: "string", default: "Бонус За Первый Депозит" },
        subtitle: { type: "string", default: "100% до €50" },
        buttonText: { type: "string", default: "Зарегистрируйтесь" },
        buttonLink: { type: "string", default: "#" },
    },

    edit: (props) => {
        const { attributes, setAttributes } = props;

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Настройки слайдера")}>
                        <TextControl
                            label="Текст кнопки"
                            value={attributes.buttonText}
                            onChange={(value) => setAttributes({ buttonText: value })}
                        />
                        <TextControl
                            label="Ссылка кнопки"
                            value={attributes.buttonLink}
                            onChange={(value) => setAttributes({ buttonLink: value })}
                        />
                    </PanelBody>
                </InspectorControls>

                <div className="gutslider-slide">
                    <MediaUpload
                        onSelect={(media) => setAttributes({ imageUrl: media.url })}
                        type="image"
                        render={({ open }) => (
                            <Button onClick={open} className="button button-primary">
                                {attributes.imageUrl ? "Заменить изображение" : "Выбрать изображение"}
                            </Button>
                        )}
                    />
                    {attributes.imageUrl && <img src={attributes.imageUrl} alt="Слайдер" className="slider-image" />}

                    <RichText
                        tagName="h2"
                        className="slider-title"
                        value={attributes.title}
                        onChange={(value) => setAttributes({ title: value })}
                        placeholder="Введите заголовок..."
                    />

                    <RichText
                        tagName="h3"
                        className="slider-subtitle"
                        value={attributes.subtitle}
                        onChange={(value) => setAttributes({ subtitle: value })}
                        placeholder="Введите подзаголовок..."
                    />

                    <a href={attributes.buttonLink} className="slider-button">
                        {attributes.buttonText}
                    </a>
                </div>
            </>
        );
    },

    save: (props) => {
        const { attributes } = props;
        return (
            <div className="gutslider-slide" style={{ backgroundImage: `url(${attributes.imageUrl})` }}>
                <h2 className="slider-title">{attributes.title}</h2>
                <h3 className="slider-subtitle">{attributes.subtitle}</h3>
                <a href={attributes.buttonLink} className="slider-button">
                    {attributes.buttonText}
                </a>
            </div>
        );
    },
});
