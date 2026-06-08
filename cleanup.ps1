$files = Get-ChildItem -Path "c:\xampp\htdocs\rentease\backend\public\*.php"
$excludeFiles = @("home.php", "shop.php", "index.php")

$replacements = @{
    "hover:bg-slate-50" = "hover:bg-surface"
    "hover:bg-slate-100" = "hover:bg-canvas"
    "hover:bg-slate-800" = "hover:bg-ink-light"
    "hover:text-slate-600" = "hover:text-ink"
    "border-teal-50" = "border-champagne/20"
    "bg-teal-500/10" = "bg-champagne/10"
    "bg-teal-500/20" = "bg-champagne/20"
    "text-teal-100/70" = "text-champagne/70"
    "text-teal-100" = "text-champagne-light"
    "text-teal-900" = "text-champagne-dark"
    "text-teal-800" = "text-champagne-dark"
    "border-teal-800/30" = "border-champagne/30"
    "bg-teal-900/10" = "bg-champagne/10"
    "selection:bg-teal-100" = "selection:bg-champagne/20"
    "bg-teal-400" = "bg-champagne"
    "shadow-slate-200/50" = "shadow-sm"
    "shadow-slate-900/20" = "shadow-lg"
    "hover:bg-teal-600" = "hover:bg-champagne-dark"
    "text-slate-200" = "text-muted-light"
    "hover:border-teal-600" = "hover:border-champagne"
    "focus:border-teal-600" = "focus:border-champagne"
    "focus:ring-teal-600" = "focus:ring-champagne"
    "peer-checked:border-teal-600" = "peer-checked:border-champagne"
    "peer-checked:bg-teal-50" = "peer-checked:bg-champagne/10"
    "peer-checked:text-teal-600" = "peer-checked:text-champagne"
    "bg-[#041627]" = "bg-ink"
}

foreach ($file in $files) {
    if ($excludeFiles -contains $file.Name) { continue }
    
    $content = Get-Content $file.FullName -Raw
    $original = $content
    
    # 1. Strip dark mode variants
    $content = [regex]::Replace($content, "dark:[a-zA-Z0-9\-\/]+", "")
    
    # 2. Cleanup double spaces caused by dark removal
    $content = [regex]::Replace($content, " {2,}", " ")

    # 3. Apply manual replacements
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
