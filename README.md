# oc-plugin-music


基于 [APlayer](https://github.com/MoePlayer/APlayer)和[a powerful music API framework](https://github.com/metowolf/Meting) 实现web端的音乐聚合搜索

## 安装

```
git clone https://github.com/jc91715/oc-plugin-music plugins/jc91715/music
```

## composer

```
cd plugins/jc91715/music && composer install
```

## 创建两个页面

例子

* /music 页，放组件 `Meting` 到这个页面上，并选择 `downPage`属性指向下载页
* /download/:id/:type?mp3  页 url 必须包含id 和 type参数

## visit yourdomain.com/music

[demo](https://jc91715.top/music)
