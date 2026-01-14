#!/bin/bash

GATEWAY_URL="http://localhost:8000"

echo "=== PRUEBAS DEL SERVICIO DE COMMENTS ==="
echo ""

echo "1. Crear un comentario (Nota: Fallará si Reviews Service no corre en 8005 o Users en 8003)..."
curl -X POST $GATEWAY_URL/comments \
  -H "Content-Type: application/json" \
  -d '{"content":"Excelente comentario","review_id":1,"user_id":1}'
echo ""
echo ""

echo "2. Listar todos los comentarios..."
curl $GATEWAY_URL/comments
echo ""
echo ""

echo "3. Intentar crear comentario con review inexistente (si Reviews service responde)..."
curl -X POST $GATEWAY_URL/comments \
  -H "Content-Type: application/json" \
  -d '{"content":"Test","review_id":99999,"user_id":1}'
echo ""
echo ""

echo "=== FIN DE PRUEBAS ==="

