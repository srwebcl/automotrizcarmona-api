<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lead Toyota no sincronizado con Salesforce</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 20px;">

    <div style="max-width: 600px; background-color: #ffffff; margin: 0 auto; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">

        <div style="background-color: #fff3cd; border: 1px solid #ffe69c; border-radius: 6px; padding: 12px 16px; margin-bottom: 20px;">
            <p style="margin: 0; color: #664d03; font-weight: bold;">⚠️ Este lead Toyota no se pudo sincronizar con Salesforce. Requiere gestión manual.</p>
        </div>

        <h2 style="color: #d2001c; margin-top: 0;">Lead Toyota — Cotización de Ventas</h2>

        @if($reason)
        <p style="color: #555555; text-transform: uppercase; font-size: 12px; font-weight: bold; margin-bottom: 5px;">Motivo del rechazo</p>
        <p style="margin-top: 0; font-size: 14px; color: #b30000; font-family: monospace; background-color: #fdf2f2; padding: 8px 12px; border-radius: 4px;">{{ $reason }}</p>
        @endif

        <hr style="border: none; border-top: 1px solid #eeeeee; margin: 20px 0;">

        <h3 style="color: #333333; margin-bottom: 10px;">Datos del Cliente</h3>
        <table style="width: 100%; border-collapse: collapse;">
            @if($lead->rut)
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777; width: 140px;">RUT</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $lead->rut }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Nombre</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $lead->name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Email</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;"><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Teléfono</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;"><a href="tel:{{ $lead->phone }}">{{ $lead->phone }}</a></td>
            </tr>
            @if($lead->raw_request && isset($lead->raw_request['vehicle']))
                @php $veh = $lead->raw_request['vehicle']; @endphp
                @if(isset($veh['brand_name']))
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Vehículo (Marca)</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $veh['brand_name'] }}</td>
                    </tr>
                @endif
                @if(isset($veh['model_name']))
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Vehículo (Modelo)</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $veh['model_name'] }}</td>
                    </tr>
                @endif
                @if(isset($veh['version_name']))
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Versión</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $veh['version_name'] }}</td>
                    </tr>
                @endif
                @if(isset($veh['sap_material_code']))
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">SAP Material Code</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $veh['sap_material_code'] }}</td>
                    </tr>
                @endif
            @endif
        </table>

        <p style="margin-top: 30px; font-size: 12px; color: #999; text-align: center;">
            Lead #{{ $lead->id }} · Este es un correo automático generado desde el sitio web de Automotriz Carmona.
        </p>
    </div>

</body>
</html>
