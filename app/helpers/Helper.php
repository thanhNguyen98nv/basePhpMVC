<?php
use \Symfony\Component\VarDumper\VarDumper;

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $v) {
            VarDumper::dump($v);
        }

        exit(1);
    }
}

if (!function_exists('config')) {
    function config($configName)
    {
        if ($configName === null || $configName === '') {
            return null;
        } else {
            $configsData = explode('.', $configName);
            $nameFileConfig = $configsData[0];

            $configs = scandir("../config");
            $configFileNames = [];
            foreach ($configs as $config) {
                if (strpos($config, '.php')) {
                    $configFileNames[] = str_replace('.php', '', $config);
                }
            }

            if (in_array($nameFileConfig, $configFileNames)) {
                $configData = include('../config/' . $nameFileConfig . '.php');

                return getAttributeInMultidimensionalArray(
                    $configData,
                    str_replace($nameFileConfig . '.', '', $configName)
                );
            }
        }
    }
}

if (!function_exists('getAttributeInMultidimensionalArray')) {
    function getAttributeInMultidimensionalArray($array, $string)
    {
        $configsData = explode('.', $string);

        if (count($configsData) > 1) {
            return getAttributeInMultidimensionalArray(
                $array[$configsData[0]],
                str_replace($configsData[0] . '.', '', $string)
            );
        } else {
            return $array[$configsData[0]];
        }
    }
}

if (!function_exists('view')) {
    function view($view = '', $data = [])
    {
        foreach ($data as $key => $items) {
            $$key = $items;
        }

        $view = @str_replace('.', '/', $view);

        $content = '../views/pages/' . $view . '.php';


        if (!file_exists($content)) {
            global $log;
            $log->error("file: " . $content . " => is not exists");

            throw new Exception("View Not Found Exception");
        }

        require $content;
    }
}

