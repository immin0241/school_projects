using UnityEngine;
using UnityEngine.Tilemaps;

public class CameraController : MonoBehaviour
{
    private Camera mainCamera;
    private Tilemap tilemap;
    public float padding = 1f; // 타일맵 주변의 여유 공간

    void Start()
    {
        mainCamera = GetComponent<Camera>();
        tilemap = FindObjectOfType<Tilemap>();
        AdjustCameraToTilemap();
    }

    void AdjustCameraToTilemap()
    {
        if (tilemap == null || mainCamera == null) return;

        // 타일맵의 경계 구하기
        BoundsInt bounds = tilemap.cellBounds;
        Vector3 center = tilemap.transform.TransformPoint(bounds.center);

        // 타일맵의 크기 계산
        float width = bounds.size.x;
        float height = bounds.size.y;

        // 화면 비율 계산
        float screenRatio = (float)Screen.width / Screen.height;
        float targetRatio = width / height;

        // 카메라 사이즈 계산
        float size;
        if (screenRatio >= targetRatio)
        {
            size = height / 2 + padding;
        }
        else
        {
            size = width / (2 * screenRatio) + padding;
        }

        // 카메라 위치와 크기 설정
        mainCamera.orthographicSize = size;
        transform.position = new Vector3(center.x, center.y, transform.position.z);
    }

    public void OnTilemapChanged()
    {
        AdjustCameraToTilemap();
    }
}