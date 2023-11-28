<?php

namespace PabloSanches\RegistroBR;

class ResponseEpp implements ResponseInterface
{
    private array $response = [];

    public function __construct(
        ?string $answer
    ) {
        $this->parseXML($answer);
    }

    public function parseXML($contents, $getAttributes = true, $priority = 'tag')
    {
        if (!function_exists('xml_parser_create')) {
            return [];
        }

        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, trim($contents), $xmlValues);
        xml_parser_free($parser);

        if (!$xmlValues) {
            return [];
        }

        $xmlArray = [];
        $parents = [];
        $openedTags = [];
        $arr = [];
        $current = &$xmlArray;
        $repeatedTagIndex = [];

        foreach ($xmlValues as $data) {
            unset($attributes, $value);

            extract($data);

            $result = [];
            $attributesData = [];

            if (isset($value)) {
                $result = ($priority == 'tag') ? $value : ['value' => $value];
            }

            if (isset($attributes) && $getAttributes) {
                foreach ($attributes as $attr => $val) {
                    if ($priority == 'tag') {
                        $attributesData[$attr] = $val;
                    } else {
                        $result['attr'][$attr] = $val;
                    }
                }
            }

            if ($type == 'open') {
                $parent[$level - 1] = &$current;

                if (!is_array($current) || (!in_array($tag, array_keys($current)))) {
                    $current[$tag] = $result;

                    if ($attributesData) {
                        $current[$tag . '_attr'] = $attributesData;
                    }

                    $repeatedTagIndex[$tag . '_' . $level] = 1;
                    $current = &$current[$tag];
                } else {
                    if (isset($current[$tag][0])) {
                        $current[$tag][$repeatedTagIndex[$tag . '_' . $level]] = $result;
                        $repeatedTagIndex[$tag . '_' . $level]++;
                    } else {
                        $current[$tag] = array($current[$tag], $result);
                        $repeatedTagIndex[$tag . '_' . $level] = 2;

                        if (isset($current[$tag . '_attr'])) {
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset($current[$tag . '_attr']);
                        }
                    }

                    $lastItemIndex = $repeatedTagIndex[$tag . '_' . $level] - 1;
                    $current = &$current[$tag][$lastItemIndex];
                }
            } elseif ($type == 'complete') {
                if (!isset($current[$tag])) {
                    $current[$tag] = $result;
                    $repeatedTagIndex[$tag . '_' . $level] = 1;

                    if ($priority == 'tag' && $attributesData) {
                        $current[$tag . '_attr'] = $attributesData;
                    }
                } else {
                    if (isset($current[$tag][0]) && is_array($current[$tag])) {
                        $current[$tag][$repeatedTagIndex[$tag . '_' . $level]] = $result;

                        if ($priority == 'tag' && $getAttributes && $attributesData) {
                            $current[$tag][$repeatedTagIndex[$tag . '_' . $level] . '_attr'] = $attributesData;
                        }

                        $repeatedTagIndex[$tag . '_' . $level]++;
                    } else {
                        $current[$tag] = array($current[$tag], $result);
                        $repeatedTagIndex[$tag . '_' . $level] = 1;

                        if ($priority == 'tag' && $getAttributes) {
                            if (isset($current[$tag . '_attr'])) {
                                $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                                unset($current[$tag . '_attr']);
                            }

                            if ($attributesData) {
                                $current[$tag][$repeatedTagIndex[$tag . '_' . $level] . '_attr'] = $attributesData;
                            }
                        }

                        $repeatedTagIndex[$tag . '_' . $level]++;
                    }
                }
            } elseif ($type == 'close') {
                $current = &$parent[$level - 1];
            }
        }

        $this->response = $xmlArray;
    }

    public function getAll(): array
    {
        return $this->response;
    }

    public function has($property): bool
    {
        return array_key_exists($property, $this->response);
    }

    public function getResponse(): array
    {
        if (array_key_exists('resData', $this->response['epp']['response'])) {
            return $this->response['epp']['response']['resData'];
        }

        return $this->response['epp']['response'];
    }
}
