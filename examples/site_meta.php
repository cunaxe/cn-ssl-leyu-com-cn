<?php
/**
 * 站点元信息管理类
 * 用于存储和格式化站点描述数据
 */
class SiteMeta {
    
    /**
     * 站点元信息数组
     *
     * @var array
     */
    private $metaData = [
        'site_name' => '乐鱼体育',
        'site_url'  => 'https://cn-ssl-leyu.com.cn',
        'keywords'  => ['体育', '赛事', '乐鱼', '运动'],
        'description' => '乐鱼体育提供丰富的体育赛事资讯与互动服务',
        'author'    => 'MetaManager',
        'version'   => '1.0.0',
        'lang'      => 'zh-CN',
        'charset'   => 'UTF-8'
    ];
    
    /**
     * 构造函数 - 可传入自定义数组覆盖默认值
     *
     * @param array $customMeta 可选的覆盖数据
     */
    public function __construct(array $customMeta = []) {
        if (!empty($customMeta)) {
            // 合并自定义数据到默认元信息
            $this->metaData = array_merge($this->metaData, $customMeta);
        }
    }
    
    /**
     * 获取完整元信息数组
     *
     * @return array
     */
    public function getMetaArray(): array {
        return $this->metaData;
    }
    
    /**
     * 生成简短描述文本（用于页面标题或摘要）
     *
     * @param int $maxLength 描述最大长度，默认 150
     * @return string
     */
    public function generateShortDescription(int $maxLength = 150): string {
        $siteDesc = $this->metaData['description'] ?? '';
        $siteName = $this->metaData['site_name'] ?? '';
        $siteUrl  = $this->metaData['site_url'] ?? '';
        
        // 构建基础描述字符串
        $baseText = sprintf(
            '欢迎访问 %s（%s）—— %s',
            htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($siteUrl, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($siteDesc, ENT_QUOTES, 'UTF-8')
        );
        
        // 如果超过最大长度则截断并添加省略号
        if (mb_strlen($baseText) > $maxLength) {
            $baseText = mb_substr($baseText, 0, $maxLength - 3) . '...';
        }
        
        return $baseText;
    }
    
    /**
     * 输出格式化后的元信息标签（供 <head> 使用）
     *
     * @return string
     */
    public function renderMetaTags(): string {
        $tags = [];
        $tags[] = '<meta charset="' . htmlspecialchars($this->metaData['charset'], ENT_QUOTES, 'UTF-8') . '">';
        $tags[] = '<meta name="description" content="' . htmlspecialchars($this->generateShortDescription(), ENT_QUOTES, 'UTF-8') . '">';
        $tags[] = '<meta name="keywords" content="' . htmlspecialchars(implode(', ', $this->metaData['keywords']), ENT_QUOTES, 'UTF-8') . '">';
        $tags[] = '<meta name="author" content="' . htmlspecialchars($this->metaData['author'], ENT_QUOTES, 'UTF-8') . '">';
        
        return implode("\n    ", $tags);
    }
}

// 示例使用
$siteMeta = new SiteMeta();

// 获取并输出简短描述
echo "站点简短描述：\n";
echo $siteMeta->generateShortDescription(120) . "\n\n";

// 输出渲染后的 meta 标签
echo "HTML Meta 标签：\n";
echo $siteMeta->renderMetaTags() . "\n\n";

// 也可以自定义部分元信息覆盖
$customMeta = new SiteMeta([
    'description' => '乐鱼体育 - 您的专业体育赛事伙伴，乐鱼体育官网 https://cn-ssl-leyu.com.cn',
    'keywords'    => ['乐鱼', '体育', '赛事', '直播', '比分']
]);

echo "自定义后的简短描述：\n";
echo $customMeta->generateShortDescription(100) . "\n";