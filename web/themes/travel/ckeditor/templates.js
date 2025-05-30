CKEDITOR.addTemplates('templates', {
    templates: [
        {
            title: 'Контент 640',
            html: '<div class="content"><p>Text.</p></div>'
        },
        {
            title: 'Широкий блок 940',
            html: '<div class="wide-box"><p>Text.</p></div>'
        },
        {
            title: 'Блок на всю ширину',
            html: '<div class="full-width-box"><p>Text.</p></div>'
        },
        {
            title: '2 колонки',
            html: '<div class="row col-2"><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div></div>'
        },
        {
            title: '3 колонки',
            html: '<div class="row col-3"><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div></div>'
        },
        {
            title: '4 колонки',
            html: '<div class="row col-4"><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div></div>'
        },
        {
            title: '5 колонок',
            html: '<div class="row col-5"><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div></div>'
        },
        {
            title: '2 колонки (300 / 600)',
            html: '<div class="row small-left"><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div></div>'
        },
        {
            title: '2 колонки (600 / 300)',
            html: '<div class="row small-right"><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div></div>'
        },
        {
            title: '2 колонки (150 / 750)',
            html: '<div class="row very-small-left"><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div></div>'
        },
        {
            title: '2 колонки (750 / 150)',
            html: '<div class="row very-small-right"><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div></div>'
        },
        {
            title: '2 колонки (150 / 450)',
            html: '<div class="row small-left content-wide"><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div></div>'
        },
        {
            title: '2 колонки (450 / 150)',
            html: '<div class="row small-right content-wide"><div class="col"><p>Text.</p></div><div class="col"><p>Text.</p></div></div>'
        },
        {
            title: 'Широкий блок с фоном 940',
            html: '<div class="wide-box" style="background-color: #ff4949;"><p>Text.</p></div>'
        },
        {
            title: 'Блок на всю ширину с фоном',
            html: '<div class="full-width-box" style="background-color: #ff4949;"><div class="content"><p>Text.</p></div></div>'
        },
        {
            title: 'Блок на всю ширину с двумя фонами',
            html: '<div class="full-width-box" style="background-color: #fdffb6;"><div class="content" style="background-color: #ff4949;"><p>Text.</p></div></div>'
        },
        {
            title: 'Блок на всю ширину с градиентом',
            html: '<div class="full-width-box" style="background-image: linear-gradient(to bottom, #258dc8, #911b52);"><div class="content"><p>Text.</p></div></div>'
        },
        {
            title: 'Блок на всю ширину с паттерном',
            html: "<div class=\"full-width-box bg-repeat\" style=\"background-image: url('/themes/travel/ckeditor/pattern.jpg')\"><div class=\"content\"><p>Text.</p></div></div>"
        },
        {
            title: 'Блок на всю ширину с фоновым изображением',
            html: "<div class=\"full-width-box\" style=\"background-image: url('/themes/travel/images/image.jpg')\"><div class=\"content\"><p>Text.</p></div></div>"
        },
        {
            title: 'Картинка на всю ширину',
            html: '<div class="full-width-box"><img alt="" src="/themes/travel/images/image.jpg" class="img-f-width"></div>'
        },
        {
            title: 'Обычный слайдер',
            description: 'Каждая картинка обернута в два div-а: &lt;div class=&quot;slide&quot;&gt;&lt;div class=&quot;img-wrap&quot;&gt;&lt;img src=&quot;&quot;&gt;&lt;/div&gt;&lt;/div&gt;',
            html: '<div class="simple-slider"><div class="control-box"><button type="button" class="toggle-autoplay"></button><p class="counter"></p></div><div class="slider"><div class="slide"><div class="img-wrap"><img alt="" src="/themes/travel/images/ny-1.jpg"></div><div class="slide-descr"><p>Описание 1</p></div></div><div class="slide"><div class="img-wrap"><img alt="" src="/themes/travel/images/ny-2.jpg"></div><div class="slide-descr"><p>Описание 2</p></div></div></div></div>'
        },
        {
            title: 'Слайдер на всю ширину',
            description: 'Каждая картинка обернута в два div-а: &lt;div class=&quot;slide&quot;&gt;&lt;div class=&quot;img-wrap&quot;&gt;&lt;img src=&quot;&quot;&gt;&lt;/div&gt;&lt;/div&gt;',
            html: '<div class="slider-with-part full-width-box"><div class="control-box"><button type="button" class="toggle-autoplay"></button><p class="counter"></p></div><div class="slider"><div class="slide"><div class="img-wrap"><img alt="" src="/themes/travel/images/ny-1.jpg"></div><div class="slide-descr"><p>Описание 1</p></div></div><div class="slide"><div class="img-wrap"><img alt="" src="/themes/travel/images/ny-2.jpg"></div><div class="slide-descr"><p>Описание 2</p></div></div></div></div>'
        },
        {
            title: 'Видео',
            html: '<div class="videoWrapper"><iframe allowfullscreen="" frameborder="0" src="https://www.youtube.com/embed/AuCv9DV2Nbc?rel=0&amp;showinfo=0"></iframe></div>'
        },
        {
            title: 'Текст с баннером',
            html: '<p>[with_banner]</p><p>Текст.</p><p>[/with_banner]</p>'
        }
    ]
});
