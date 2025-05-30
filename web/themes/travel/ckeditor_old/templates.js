CKEDITOR.addTemplates('templates', {
    templates: [
        {
            title: 'Широкий блок',
            html: '<div class="full-width"><p>Текст.</p></div>'
        },
        {
            title: 'Две колонки',
            html: '<div class="full-width-2col"><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div></div>'
        },
        {
            title: 'Три колонки',
            html: '<div class="full-width-3col"><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div></div>'
        },
        {
            title: 'Четыре колонки',
            html: '<div class="full-width-4col"><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div></div>'
        },
        {
            title: 'Пять колонок',
            html: '<div class="full-width-5col"><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div></div>'
        },
        {
            title: 'Две колонки 300x600',
            html: '<div class="full-width-300col"><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div></div>'
        },
        {
            title: 'Две колонки 600x300',
            html: '<div class="full-width-600col"><div class="col"><p>Текст.</p></div><div class="col"><p>Текст.</p></div></div>'
        },
        {
            title: 'Черный блок, широкий текст',
            html: '<div class="bg-full-width-black full-width-box"><div class="text-content"><p>Текст.</p></div></div>'
        },
        {
            title: 'Черный блок, узкий текст',
            html: '<div class="bg-full-width-black full-width-box"><div class="text-content-small"><p>Текст.</p></div></div>'
        },
        {
            title: 'Цветной блок, широкий текст',
            description: 'Фоновый цвет или картинку можно изменить с помощью inline-стилей "background-color" и "background-image"',
            html: '<div class="bg-fullwidthcolor full-width-box"><div class="text-content"><p>Текст.</p></div></div>'
        },
        {
            title: 'Цветной блок, узкий текст',
            description: 'Фоновый цвет или картинку можно изменить с помощью inline-стилей "background-color" и "background-image"',
            html: '<div class="bg-fullwidthcolor full-width-box"><div class="text-content-small"><p>Текст.</p></div></div>'
        },
        {
            title: 'Цветной блок с отступами',
            description: 'Фоновый цвет или картинку можно изменить с помощью inline-стилей "background-color" и "background-image"',
            html: '<div class="bg-full-width-color-wrap" style="background-color:#ff4949"><div class="text-content-small"><p>Текст.</p></div></div>'
        },
        {
            title: 'Картинка на всю ширину',
            html: '<div class="full-width-box full-width-img"><img alt="" src="/themes/travel/images/thumb-6.jpg"></div>'
        },
        {
            title: 'Новый слайдер',
            description: 'Каждая картинка обернута в два div-а: &lt;div class=&quot;slide&quot;&gt;&lt;div class=&quot;img-wrap&quot;&gt;&lt;img src=&quot;&quot;&gt;&lt;/div&gt;&lt;/div&gt;',
            html: '<div class="slider-with-part full-width-box"><div class="control-box"><button type="button" class="toggle-autoplay"></button><p class="counter"></p></div><div class="slider"><div class="slide"><div class="img-wrap"><img alt="" src="/themes/travel/images/thumb-6.jpg"></div></div><div class="slide"><div class="img-wrap"><img alt="" src="/themes/travel/images/thumb-7.jpg"></div></div></div></div>'
        },
        {
            title: 'Текст с баннером',
            html: '<p>[with_banner]</p><p>Текст.</p><p>[/with_banner]</p>'
        }
    ]
});
