$files = Get-ChildItem -Path "c:\xampp\htdocs\rentease\backend\public\*.php"
$excludeFiles = @("home.php", "shop.php", "index.php")

$replacements = @{
    "bg-slate-900" = "bg-ink"
    "text-slate-900" = "text-ink"
    "text-slate-800" = "text-ink"
    "text-slate-700" = "text-ink"
    "text-slate-600" = "text-ink"
    "bg-slate-50" = "bg-surface"
    "bg-gray-50" = "bg-surface"
    "bg-gray-100" = "bg-canvas"
    "text-gray-900" = "text-ink"
    "text-gray-600" = "text-muted"
    "text-gray-500" = "text-muted"
    "text-slate-500" = "text-muted"
    "text-slate-400" = "text-muted-light"
    "text-slate-300" = "text-muted-light"
    "bg-slate-100" = "bg-canvas"
    "bg-slate-200" = "bg-canvas"
    "border-slate-100" = "border-border"
    "border-slate-200" = "border-border"
    "border-gray-100" = "border-border"
    "border-gray-200" = "border-border"
    
    "bg-teal-50" = "bg-champagne/10"
    "bg-teal-100" = "bg-champagne/20"
    "bg-teal-400" = "bg-champagne"
    "bg-teal-500" = "bg-champagne"
    "bg-teal-600" = "bg-champagne-dark"
    "bg-teal-700" = "bg-champagne-dark"
    
    "text-teal-400" = "text-champagne"
    "text-teal-500" = "text-champagne"
    "text-teal-600" = "text-champagne-dark"
    "text-teal-700" = "text-champagne-dark"
    
    "border-teal-100" = "border-champagne/20"
    "border-teal-500" = "border-champagne"
    "border-teal-600" = "border-champagne-dark"
    "ring-teal-500" = "ring-champagne"
    "ring-teal-100" = "ring-champagne/20"

    "bg-blue-50" = "bg-canvas"
    "text-blue-500" = "text-champagne"
    "text-blue-600" = "text-champagne-dark"
    "text-blue-700" = "text-champagne-dark"
    "bg-blue-600" = "bg-champagne-dark"
    
    "bg-indigo-50" = "bg-champagne/10"
    "text-indigo-600" = "text-champagne-dark"
    "bg-indigo-600" = "bg-champagne-dark"
    
    "bg-orange-50" = "bg-rose/10"
    "text-orange-600" = "text-rose"
    "bg-purple-50" = "bg-champagne/10"
    "text-purple-600" = "text-champagne-dark"
    
    "text-primary" = "text-ink"
    "bg-primary" = "bg-ink"
    "bg-secondary" = "bg-champagne"
    "text-secondary" = "text-champagne-dark"
    "border-secondary" = "border-champagne"
    "ring-secondary" = "ring-champagne"
    
    "text-zinc-900" = "text-ink"
    "text-zinc-500" = "text-muted"
    "bg-zinc-50" = "bg-surface"
}

foreach ($file in $files) {
    if ($excludeFiles -contains $file.Name) { continue }
    
    $content = Get-Content $file.FullName -Raw
    $original = $content
    
    # Sort keys by length descending to avoid partial matches replacing parts of longer class names
    $keys = $replacements.Keys | Sort-Object Length -Descending
    
    foreach ($key in $keys) {
        $val = $replacements[$key]
        # Regex to only match exact class names (surrounded by word boundaries or space/quote)
        $pattern = "(?<=[\s""'])" + [regex]::Escape($key) + "(?=[\s""'])"
        $content = [regex]::Replace($content, $pattern, $val)
    }
    
    if ($content -cne $original) {
        Set-Content -Path $file.FullName -Value $content -NoNewline
        Write-Host "Updated $($file.Name)"
    }
}
