<?php


namespace Database\Seeders\data;


class Brands
{
    public static function getData(): array
    {
        $data = [
            [
                'name' => 'AMD',
                'slug' => 'amd',
                'description' => 'AMD (аббревиатура от Advanced Micro Devices, Inc.) – американская компания по производству интегральной электроники. AMD является крупнейшим поставщиком графических процессоров, чипсетов для материнских плат и флэш-памяти; а также вторым по величине производителем х86 и х64-совместимых процессоров. Основным конкурентом компании является Intel; однако, при высоком уровне качества продукции и производительности, AMD стремится сделать свои цены более демократичными. Партнёрами компании на рынке персональных компьютеров являются: Acer, Fujitsu, Fujitsu Technology Solutions, IBM; на рынке телекоммуникационных систем: Alcatel-Lucent, AT&T, Ericsson, NEC, Siemens AG, Sony.
AMD начала свою деятельность в 1969 году с производства логических интегральных микросхем. В 2006 году произошло слияние с разработчиком графических чипов ATI, и уже с 2007 года AMD начала производство своих графических чипов. В том же году появились первые четырёхъядерные процессоры Phenom X4. Компания развивает программное обеспечение, оптимизируя его под свои платформы. На данный момент на счету AMD имеется ряд разработок и технических достижений, в том числе уникальных, что позволяет ей оставаться одним из ведущих мировых производителей графических процессоров.',
            ],

            [
                'name' => 'Intel',
                'slug' => 'intel',
                'description' => 'Сложно представить себе человека, который бы хоть раз не слышал о компании Intel и ее знаменитых микропроцессорах, которые обеспечивают стабильную работу миллионам компьютеров по всему миру. Однако компания славится не только этим. Intel Corporation – это американская корпорация, которая производит широкий спектр электронных устройств и компьютерных компонентов, в том числе и микропроцессоры, наборы системной логики (чипсеты) и др. Компания стала известна еще в начале 70-х годов 20 века, когда начала сотрудничество с японской компанией Busicom. Intel получила заказ на двенадцать специализированных микросхем, но по предложению инженера Тэда Хоффа компания разработала один универсальный микропроцессор Intel 4004. Необычный и оригинальный подход к решению даже самых простых вопросов, стал основополагающей идеей развития для всемирно известной корпорации.
Intel появилась в США 18 июля 1968 когда, когда Роберт Нойс и Гордон Мур ушли из компании Fairchild Semiconductor. По сути компания начинала с максимума амбиций и минимума ресурсов – бизнес-план будущей корпорации занимал всего одну страницу, а стартовый капитал оценивался в $2,5 млн., однако даже этого хватило для того, чтобы завоевать мировую известность. В 90-е Intel уже стала крупнейшим производителем процессоров для персональных компьютеров, и является им до сих пор.',
            ],

            [
                'name' => 'Gigabyte',
                'slug' => 'gigabyte',
                'description' => 'Компания GIGABYTE считается одним из лидирующих производителей материнских и графических плат, известных и востребованных по всему миру. Она не только входит в двадцатку самых популярных тайваньских компаний, но и не единожды удостаивалась множества всевозможных наград от авторитетных организаций и печатных изданий с мировым именем. Передовые технологии и инновационный подход к созданию продукции GIGABYTE позволяет ему идти в ногу со временем, а также обеспечивает высокое качество всему, что производится под этим брендом. Способность не только предлагать исключительно актуальные и необходимые потребителю товары, но и нести за них полную гарантийную ответственность делаю компанию отвечающей требованиям даже самых взыскательных покупателей. Расположенные по миру сервисные центры и техническая поддержка онлайн помогают найти лучшие решения в случае возникновения любых проблем.',
            ],

            [
                'name' => 'Asus',
                'slug' => 'asus',
                'description' => 'Компания ASUS – крупнейший тайваньский производитель компьютерной техники. По словам основателей, их главные ориентиры – это вдохновение и творчество. Именно они являются основой философии компании и тем фундаментом, на котором основаны все ее разработки.
Компания была основана в 1989 году, и вначале в ней царил своеобразный "матриархат": она занималась только выпуском материнских плат. С тех пор ассортимент ее значительно расширился, однако до сих пор компания ASUS владеет одним из самых больших сегментов в этой отрасли: по статистике, материнская плата ASUS установлена в каждом третьем компьютере из всех компьютеров мира. Сегодня, помимо материнских плат, компания выпускает и другие комплектующие, а также ноутбуки, мониторы и даже мобильные телефоны.',
            ],

            [
                'name' => 'Crucial',
                'slug' => 'crucial',
                'description' => 'Являясь брендом Micron, одного из крупнейших производителей модулей памяти в мире, Crucial привносит качество и знания, которые совершенствовались более 35 лет. Компания постоянно находится в поиске инновационных технологий и уникальных решений. Инструменты бренда System Scanner и Crucial Advisor помогут всего за три шага узнать о вашей системе, чтобы предоставить список гарантированных совместимых компонентов - это займет меньше минуты.',
            ],

            [
                'name' => 'Noctua',
                'slug' => 'noctua',
                'description' => 'Компания  Noctua - австрийский производитель воздушных систем охлаждения для компьютеров. Продукция компании относится к сегменту хай-энд. Эти кулеры и вентиляторы отличаются бесшумностью работы, высокой эффективностью и исключительной надежностью. Модельный ряд невелик, но каждое творение заслуживает самого пристального внимания.',
            ],

            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'description' => 'Более 70 лет компания Samsung старается сделать мир лучше и совершеннее, осуществляя свою деятельность в разнообразных направлениях: производство полупроводников и цифровых устройств, строительство небоскребов и производственных комплексов, нефтехимическая промышленность, мода и стиль, медицина, финансовые услуги, гостиничные сети и многое другое. Наш флагман, компания Samsung Electronics, является признанным мировым лидером в производстве электроники и цифровой техники на базе самых современных технологий.',
            ],

            [
                'name' => 'Western Digital',
                'slug' => 'western-digital',
                'description' => 'Компания Western Digital обеспечивает условия для максимально эффективного использования данных. Занимая лидирующие позиции в сфере инфраструктуры данных, компания создает инновации, необходимые пользователям для записи, сохранения, вызова и обработки все бóльших объемов разнообразных данных. Везде, где есть данные – от передовых ЦОДов до мобильных датчиков и потребительских устройств – лучшие в отрасли решения Western Digital позволяют раскрыть весь потенциал данных.',
            ],

            [
                'name' => 'Seagate',
                'slug' => 'seagate',
                'description' => 'Seagate Technology – это американская компания, мировой лидер среди разработчиков решений для хранения данных. Вот уже более тридцати лет она занимается производством лучших жестких дисков, которые позволяют пользователям по всему миру создавать, обмениваться и хранить важные данные.',
            ],

            [
                'name' => 'Toshiba',
                'slug' => 'toshiba',
                'description' => 'Всемирно известная марка Toshiba начала свою историю в далёком 1875 году и сначала носила название Tanaka Engineering Works. За короткий срок компания стала первой производить в Японии телеграфное оборудование. Основателем компании является Хисашиге Танака, изобретатель по профессии. В числе его наиболее ярких изобретений значились механические куклы и часы, не требующие завода. Вскоре Tanaka Engineering Works стала одним из мощнейших в Японии производителей качественного электротехнического оборудования.',
            ],
        ];

        foreach ($data as $brand) {
            $brand['created_at'] = now();
            $brand['updated_at'] = now();
        }

        return $data;
    }
}
