$files = Get-ChildItem -Path "c:\xampp\htdocs\rentease\backend\public\*.php"
$excludeFiles = @("home.php", "shop.php", "index.php")

$replacements = @{
    "bg-indigo-100" = "bg-champagne/20"
    "bg-indigo-500" = "bg-champagne"
    "text-indigo-600" = "text-champagne-dark"
    "bg-indigo-500/20" = "bg-champagne/20"
    "bg-blue-100" = "bg-champagne/20"
    "bg-blue-50/50" = "bg-champagne/10"
    "border-blue-100" = "border-champagne/20"
    "hover:bg-blue-700" = "hover:bg-champagne-dark"
    "shadow-blue-500/20" = "shadow-lg"
    "text-orange-500" = "text-champagne"
    "text-orange-600" = "text-champagne-dark"
    "bg-orange-50" = "bg-champagne/10"
    "bg-purple-500" = "bg-champagne"
    "bg-purple-50" = "bg-champagne/10"
    "text-purple-600" = "text-champagne-dark"
    "bg-slate-50/50" = "bg-surface"
    "hover:bg-slate-50/50" = "hover:bg-surface"
    "placeholder:text-slate-300" = "placeholder:text-muted-light"
}

foreach ($file in $files) {
    if ($excludeFiles -contains $file.Name) { continue }
    
    $content = Get-Content $file.FullName -Raw
    $original = $content

    $keys = $replacements.Keys | Sort-Object Length -Descending
    foreach ($key in $keys) {
        $val = $replacements[$key]
        $pattern = "(?<=[\s""'])" + [regex]::Escape($key) + "(?=[\s""'])"
        $content = [regex]::Replace($content, $pattern, $val)
    }
    
    if ($content -cne $original) {
        Set-Content -Path $file.FullName -Value $content -NoNewline
        Write-Host "Updated $($file.Name)"
    }
}
