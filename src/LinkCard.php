<?php

namespace App\Render;

/**
 * 链接卡片生成器
 * 用于展示带标题、描述和链接的卡片HTML
 */
class LinkCard
{
    /**
     * 默认站点信息
     */
    private const SITE_NAME = '爱游戏';
    private const SITE_URL = 'https://i-gameportal.com.cn';

    /**
     * 卡片样式配置
     */
    private array $styleConfig;

    public function __construct(array $styleConfig = [])
    {
        $defaultConfig = [
            'borderColor' => '#3498db',
            'bgColor' => '#ffffff',
            'textColor' => '#333333',
            'linkColor' => '#2980b9',
            'hoverColor' => '#1f6390',
            'borderRadius' => '12px',
            'shadow' => true,
        ];

        $this->styleConfig = array_merge($defaultConfig, $styleConfig);
    }

    /**
     * 渲染单个链接卡片
     *
     * @param string $title 卡片标题
     * @param string $description 卡片描述
     * @param string $url 链接地址
     * @param string $siteName 站点名称（可选）
     * @return string 转义后的HTML片段
     */
    public function renderCard(
        string $title,
        string $description,
        string $url = '',
        string $siteName = ''
    ): string {
        $finalUrl = $url ?: self::SITE_URL;
        $finalSite = $siteName ?: self::SITE_NAME;

        $escapedTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $escapedDesc = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
        $escapedUrl = htmlspecialchars($finalUrl, ENT_QUOTES, 'UTF-8');
        $escapedSite = htmlspecialchars($finalSite, ENT_QUOTES, 'UTF-8');

        $border = htmlspecialchars($this->styleConfig['borderColor'], ENT_QUOTES, 'UTF-8');
        $bg = htmlspecialchars($this->styleConfig['bgColor'], ENT_QUOTES, 'UTF-8');
        $text = htmlspecialchars($this->styleConfig['textColor'], ENT_QUOTES, 'UTF-8');
        $link = htmlspecialchars($this->styleConfig['linkColor'], ENT_QUOTES, 'UTF-8');
        $hover = htmlspecialchars($this->styleConfig['hoverColor'], ENT_QUOTES, 'UTF-8');
        $radius = htmlspecialchars($this->styleConfig['borderRadius'], ENT_QUOTES, 'UTF-8');
        $shadowStyle = $this->styleConfig['shadow'] ? 'box-shadow: 0 4px 12px rgba(0,0,0,0.1);' : '';

        $card = <<<HTML
<div style="border: 2px solid {$border}; background: {$bg}; border-radius: {$radius}; padding: 20px; max-width: 400px; margin: 16px auto; {$shadowStyle} font-family: sans-serif;">
    <h3 style="color: {$text}; margin: 0 0 8px 0; font-size: 1.4em;">{$escapedTitle}</h3>
    <p style="color: {$text}; margin: 0 0 14px 0; line-height: 1.5;">{$escapedDesc}</p>
    <a href="{$escapedUrl}" style="color: {$link}; text-decoration: none; font-weight: bold; padding: 6px 14px; border: 1px solid {$link}; border-radius: 6px; display: inline-block; transition: background 0.2s;" onmouseover="this.style.background='{$hover}'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='{$link}';">前往 {$escapedSite}</a>
</div>
HTML;

        return $card;
    }

    /**
     * 渲染一组卡片（示例数据）
     *
     * @return string 拼接后的HTML
     */
    public function renderSampleCards(): string
    {
        $cards = [];

        $cards[] = $this->renderCard(
            '爱游戏门户',
            '发现最新热门游戏资讯、攻略和社区动态，一站式游戏体验平台。',
            self::SITE_URL,
            self::SITE_NAME
        );

        $cards[] = $this->renderCard(
            '游戏评测专区',
            '专业编辑深度测评，助你挑选最适合的游戏作品。',
            'https://i-gameportal.com.cn/reviews'
        );

        $cards[] = $this->renderCard(
            '玩家社区',
            '与千万玩家交流心得，分享你的游戏精彩瞬间。',
            'https://i-gameportal.com.cn/community'
        );

        return implode("\n", $cards);
    }

    /**
     * 动态渲染自定义卡片列表
     *
     * @param array $items 每项包含 title, description, url 的数组
     * @return string
     */
    public function renderCardList(array $items): string
    {
        $output = '';
        foreach ($items as $item) {
            $title = $item['title'] ?? '未命名';
            $desc = $item['description'] ?? '';
            $url = $item['url'] ?? self::SITE_URL;
            $output .= $this->renderCard($title, $desc, $url) . "\n";
        }
        return $output;
    }
}