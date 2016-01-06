<?php

namespace Examples\Entity;

use FastD\Database\ORM\Entity;

class ShopContent1Shop extends Entity
{
    /**
     * @const string
     */
    const PRIMARY = \Examples\Fields\ShopContent1ShopFields::PRIMARY;

    /**
     * Fields const
     * @const array
     */
    const FIELDS = \Examples\Fields\ShopContent1ShopFields::FIELDS;

    /**
     * Fields alias
     * @const array
     */
    const ALIAS = \Examples\Fields\ShopContent1ShopFields::ALIAS;

    /**
     * @var string
     */
    protected $table = 'shop_content_1_shop';

    /**
     * @var string|null
     */
    protected $repository = 'Examples\Repository\ShopContent1ShopRepository';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $catid;

    /**
     * @var mixed
     */
    protected $content;

    /**
     * @var string
     */
    protected $images;

    /**
     * @var mixed
     */
    protected $price;

    /**
     * @var string
     */
    protected $fubiaoti;

    /**
     * @var mixed
     */
    protected $haoping;

    /**
     * @var mixed
     */
    protected $yueshouliang;

    /**
     * @var string
     */
    protected $taobaowangzhi;

    /**
     * @var string
     */
    protected $dashikaiguang;

    /**
     * @var string
     */
    protected $zhenshianli;

    /**
     * @var mixed
     */
    protected $marketprice;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var int
     */
    protected $kucun;

    /**
     * @var string
     */
    protected $jiuneirong;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var string
     */
    protected $itemads;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var int
     */
    protected $ishdfk;

    /**
     * @var string
     */
    protected $zodiacopt;

    /**
     * @var string
     */
    protected $kuanshi;

    /**
     * @var int
     */
    protected $isshowlist;

    /**
     * @var string
     */
    protected $hrefurl;

    /**
     * getId
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * setId
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * getCatid
     *
     * @return string
     */
    public function getCatid()
    {
        return $this->catid;
    }

    /**
     * setCatid
     *
     * @param string $catid
     * @return $this
     */
    public function setCatid($catid)
    {
        $this->catid = $catid;

        return $this;
    }

    /**
     * getContent
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * setContent
     *
     * @param mixed $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * getImages
     *
     * @return string
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * setImages
     *
     * @param string $images
     * @return $this
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * getPrice
     *
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * setPrice
     *
     * @param mixed $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * getFubiaoti
     *
     * @return string
     */
    public function getFubiaoti()
    {
        return $this->fubiaoti;
    }

    /**
     * setFubiaoti
     *
     * @param string $fubiaoti
     * @return $this
     */
    public function setFubiaoti($fubiaoti)
    {
        $this->fubiaoti = $fubiaoti;

        return $this;
    }

    /**
     * getHaoping
     *
     * @return mixed
     */
    public function getHaoping()
    {
        return $this->haoping;
    }

    /**
     * setHaoping
     *
     * @param mixed $haoping
     * @return $this
     */
    public function setHaoping($haoping)
    {
        $this->haoping = $haoping;

        return $this;
    }

    /**
     * getYueshouliang
     *
     * @return mixed
     */
    public function getYueshouliang()
    {
        return $this->yueshouliang;
    }

    /**
     * setYueshouliang
     *
     * @param mixed $yueshouliang
     * @return $this
     */
    public function setYueshouliang($yueshouliang)
    {
        $this->yueshouliang = $yueshouliang;

        return $this;
    }

    /**
     * getTaobaowangzhi
     *
     * @return string
     */
    public function getTaobaowangzhi()
    {
        return $this->taobaowangzhi;
    }

    /**
     * setTaobaowangzhi
     *
     * @param string $taobaowangzhi
     * @return $this
     */
    public function setTaobaowangzhi($taobaowangzhi)
    {
        $this->taobaowangzhi = $taobaowangzhi;

        return $this;
    }

    /**
     * getDashikaiguang
     *
     * @return string
     */
    public function getDashikaiguang()
    {
        return $this->dashikaiguang;
    }

    /**
     * setDashikaiguang
     *
     * @param string $dashikaiguang
     * @return $this
     */
    public function setDashikaiguang($dashikaiguang)
    {
        $this->dashikaiguang = $dashikaiguang;

        return $this;
    }

    /**
     * getZhenshianli
     *
     * @return string
     */
    public function getZhenshianli()
    {
        return $this->zhenshianli;
    }

    /**
     * setZhenshianli
     *
     * @param string $zhenshianli
     * @return $this
     */
    public function setZhenshianli($zhenshianli)
    {
        $this->zhenshianli = $zhenshianli;

        return $this;
    }

    /**
     * getMarketprice
     *
     * @return mixed
     */
    public function getMarketprice()
    {
        return $this->marketprice;
    }

    /**
     * setMarketprice
     *
     * @param mixed $marketprice
     * @return $this
     */
    public function setMarketprice($marketprice)
    {
        $this->marketprice = $marketprice;

        return $this;
    }

    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * setAlias
     *
     * @param string $alias
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * getKucun
     *
     * @return int
     */
    public function getKucun()
    {
        return $this->kucun;
    }

    /**
     * setKucun
     *
     * @param int $kucun
     * @return $this
     */
    public function setKucun($kucun)
    {
        $this->kucun = $kucun;

        return $this;
    }

    /**
     * getJiuneirong
     *
     * @return string
     */
    public function getJiuneirong()
    {
        return $this->jiuneirong;
    }

    /**
     * setJiuneirong
     *
     * @param string $jiuneirong
     * @return $this
     */
    public function setJiuneirong($jiuneirong)
    {
        $this->jiuneirong = $jiuneirong;

        return $this;
    }

    /**
     * getTemplate
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * setTemplate
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * getItemads
     *
     * @return string
     */
    public function getItemads()
    {
        return $this->itemads;
    }

    /**
     * setItemads
     *
     * @param string $itemads
     * @return $this
     */
    public function setItemads($itemads)
    {
        $this->itemads = $itemads;

        return $this;
    }

    /**
     * getSku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * setSku
     *
     * @param string $sku
     * @return $this
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * getIshdfk
     *
     * @return int
     */
    public function getIshdfk()
    {
        return $this->ishdfk;
    }

    /**
     * setIshdfk
     *
     * @param int $ishdfk
     * @return $this
     */
    public function setIshdfk($ishdfk)
    {
        $this->ishdfk = $ishdfk;

        return $this;
    }

    /**
     * getZodiacopt
     *
     * @return string
     */
    public function getZodiacopt()
    {
        return $this->zodiacopt;
    }

    /**
     * setZodiacopt
     *
     * @param string $zodiacopt
     * @return $this
     */
    public function setZodiacopt($zodiacopt)
    {
        $this->zodiacopt = $zodiacopt;

        return $this;
    }

    /**
     * getKuanshi
     *
     * @return string
     */
    public function getKuanshi()
    {
        return $this->kuanshi;
    }

    /**
     * setKuanshi
     *
     * @param string $kuanshi
     * @return $this
     */
    public function setKuanshi($kuanshi)
    {
        $this->kuanshi = $kuanshi;

        return $this;
    }

    /**
     * getIsshowlist
     *
     * @return int
     */
    public function getIsshowlist()
    {
        return $this->isshowlist;
    }

    /**
     * setIsshowlist
     *
     * @param int $isshowlist
     * @return $this
     */
    public function setIsshowlist($isshowlist)
    {
        $this->isshowlist = $isshowlist;

        return $this;
    }

    /**
     * getHrefurl
     *
     * @return string
     */
    public function getHrefurl()
    {
        return $this->hrefurl;
    }

    /**
     * setHrefurl
     *
     * @param string $hrefurl
     * @return $this
     */
    public function setHrefurl($hrefurl)
    {
        $this->hrefurl = $hrefurl;

        return $this;
    }
}