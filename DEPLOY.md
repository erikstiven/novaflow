# Despliegue Temporal con Cloudflare Tunnel

## Requisitos

- [cloudflared](https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/downloads/) instalado
- PHP instalado (para el servidor local)
- Servidor PHP local corriendo en `http://127.0.0.1:8000`

## Despliegue Rápido (Quick Tunnel - sin autenticación)

```bash
# 1. Iniciar servidor PHP local (si no está corriendo)
php -S 127.0.0.1:8000

# 2. En otra terminal, crear túnel a trycloudflare.com
cloudflared tunnel --url http://127.0.0.1:8000
```

Esto genera una URL como `https://random-name.trycloudflare.com` que expone el sitio local a internet. El túnel permanece activo mientras el proceso de `cloudflared` esté corriendo.

## Despliegue Permanente (con autenticación)

```bash
# 1. Autenticar cloudflared con tu cuenta de Cloudflare
cloudflared login

# 2. Crear un túnel con nombre
cloudflared tunnel create novaflow

# 3. Crear archivo de configuración ~/.cloudflared/config.yml
#    tunnel: <TUNNEL-UUID>
#    credentials-file: C:\Users\<USER>\.cloudflared\<TUNNEL-UUID>.json
#    ingress:
#      - hostname: novaflow.tudominio.com
#        service: http://localhost:8000
#      - service: http_status:404

# 4. Configurar DNS (apunta el dominio al túnel)
cloudflared tunnel route dns <TUNNEL-UUID> novaflow.tudominio.com

# 5. Ejecutar el túnel
cloudflared tunnel run <TUNNEL-UUID>
```

## Notas

- El Quick Tunnel es ideal para presentaciones temporales. La URL es aleatoria y cambia cada vez.
- El túnel autenticado permite usar un dominio propio y configuración persistente.
- Mantener ambos procesos (PHP y cloudflared) corriendo simultáneamente.
