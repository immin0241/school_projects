using UnityEngine;
using UnityEngine.Tilemaps;
using TMPro;
using System.Net.Sockets;
using System;
using System.Text;

public class PlayerController : MonoBehaviour
{
    private Tilemap tilemap;
    public float gridSize = 1f;
    public float moveSpeed = 5f;

    private int score = 0;
    public TextMeshProUGUI scoreText;
    private int currentStage = 1;

    public TileBase breakableTile;
    public TileBase unbreakableTile;
    public TileBase itemTile;

    private bool isMoving = false;
    private Vector3 targetPosition;

    private TcpClient client;
    private NetworkStream stream;
    private Vector3 movement;

    // 각 스테이지별 맵 데이터
    private readonly string[] stage2Map = new string[]
    {
        "WWWWWWWWWWWWWWW",
        "WXBBIBBBIBBBBBW",
        "WBWWWWWBWWWWWBW",
        "WBIBIBBBBBIBIBW",
        "WBWWWBWBWBWWWBW",
        "WBBBIBBBIBBBBBW",
        "WBWWWBWBWBWWWBW",
        "WBIBIBBBBBIBIBW",
        "WBWWWWWBWWWWWBW",
        "WBBBIBBBIBBBBBW",
        "WWWWWWWWWWWWWWW"
    };

    private readonly string[] stage3Map = new string[]
    {
        "WWWWWWWWWWWWWWWWW",
        "WXBBIBBBBBIBBBBBW",
        "WBWWWBWWWBWWWWWBW",
        "WBIBIBBBBBBIBIBBW",
        "WBWBWWWBWWWBWBWBW",
        "WBBBIBBBIBBBIBBW",
        "WBWBWWWBWWWBWBWBW",
        "WBIBIBBBBBBIBIBBW",
        "WBWWWBWWWBWWWWWBW",
        "WBBBIBBBBBIBBBBBW",
        "WWWWWWWWWWWWWWWWW"
    };

    private readonly string[] stage4Map = new string[]
    {
        "WWWWWWWWWWWWWWWWWWW",
        "WXBBIBBBBBBBIBBBBBW",
        "WBWWWBWWWWWBWWWWWBW",
        "WBIBIBBBBBBBBIBIBBW",
        "WBWBWWWBWBWBWWBWWBW",
        "WBBBIBBBIBIBBBIBBW",
        "WBWBWWWBWBWBWWBWWBW",
        "WBIBIBBBBBBBBIBIBBW",
        "WBWWWBWWWWWBWWWWWBW",
        "WBBBIBBBBBBBIBBBBBW",
        "WWWWWWWWWWWWWWWWWWW"
    };

    private readonly string[] stage5Map = new string[]
    {
        "WWWWWWWWWWWWWWWWWWWW",
        "WXBBIBBBBBBBBIBBBBBBW",
        "WBWWWBWWWWWWBWWWWWWBW",
        "WBIBIBBBBBBBBBBIBIBBW",
        "WBWBWWWBWWBWWBWWBWWBW",
        "WBBBIBBBIBIIBIBBIBBW",
        "WBWBWWWBWWBWWBWWBWWBW",
        "WBIBIBBBBBBBBBBIBIBBW",
        "WBWWWBWWWWWWBWWWWWWBW",
        "WBBBIBBBBBBBBIBBBBBBW",
        "WWWWWWWWWWWWWWWWWWWWW"
    };

    void Start()
    {
        tilemap = FindObjectOfType<Tilemap>();
        targetPosition = transform.position;
        UpdateScoreDisplay();

        ConnectToMiddleware();
    }

    void Update()
    {
        if (stream != null && stream.DataAvailable)
        {
            byte[] buffer = new byte[1024];
            int bytesRead = stream.Read(buffer, 0, buffer.Length);
            if (bytesRead > 0)
            {
                string command = Encoding.UTF8.GetString(buffer, 0, bytesRead).Trim();

                if (command.Equals("Right"))
                    movement = Vector3.right;
                else if (command.Equals("Left"))
                    movement = Vector3.left;
                else if (command.Equals("Up"))
                    movement = Vector3.up;
                else if (command.Equals("Down"))
                    movement = Vector3.down;

                Debug.Log($"Received command: {command}");
            }
        }

        ProcessCommand();
        CheckStageProgress();
    }

    void ConnectToMiddleware()
    {
        try
        {
            client = new TcpClient("127.0.0.1", 9999); // Middleware IP and port
            stream = client.GetStream();
            Debug.Log("Connected to Kinect Middleware.");
        }
        catch (Exception ex)
        {
            Debug.LogError($"Failed to connect to middleware: {ex.Message}");
        }
    }

    void ProcessCommand()
    {
        if (!isMoving)
        {
            if (movement != Vector3.zero)
            {
                Vector3 newPosition = targetPosition + movement * gridSize;
                Vector3Int newCell = tilemap.WorldToCell(newPosition);

                if (CanMoveToTile(newCell))
                {
                    targetPosition = newPosition;
                    isMoving = true;
                }
            }
        }

        if (isMoving)
        {
            transform.position = Vector3.MoveTowards(transform.position, targetPosition, moveSpeed * Time.deltaTime);

            if (Vector3.Distance(transform.position, targetPosition) < 0.001f)
            {
                transform.position = targetPosition;
                movement = Vector3.zero;
                isMoving = false;
                HandleTileAtPosition(tilemap.WorldToCell(transform.position));
            }
        }
    }

    void OnDestroy()
    {
        // Cleanup network resources
        if (stream != null) stream.Close();
        if (client != null) client.Close();
    }

    void CheckStageProgress()
    {
        int newStage = (score / 1000) + 1;
        if (newStage != currentStage && newStage <= 5)
        {
            currentStage = newStage;
            ChangeStage(currentStage);
        }
    }

    void ChangeStage(int stage)
    {
        string[] currentMap = null;
        switch (stage)
        {
            case 2:
                currentMap = stage2Map;
                break;
            case 3:
                currentMap = stage3Map;
                break;
            case 4:
                currentMap = stage4Map;
                break;
            case 5:
                currentMap = stage5Map;
                break;
            default:
                return;
        }

        tilemap.ClearAllTiles();

        for (int y = 0; y < currentMap.Length; y++)
        {
            string row = currentMap[y];
            for (int x = 0; x < row.Length; x++)
            {
                Vector3Int position = new Vector3Int(x, -y, 0);

                switch (row[x])
                {
                    case 'W':
                        tilemap.SetTile(position, unbreakableTile);
                        break;
                    case 'B':
                        tilemap.SetTile(position, breakableTile);
                        break;
                    case 'I':
                        tilemap.SetTile(position, itemTile);
                        break;
                }
            }
        }

        Vector3 newPlayerPosition = tilemap.GetCellCenterWorld(new Vector3Int(1, -1, 0));
        transform.position = newPlayerPosition;
        targetPosition = newPlayerPosition;

        var cameraController = Camera.main.GetComponent<CameraController>();
        if (cameraController != null)
        {
            cameraController.OnTilemapChanged();
        }
    }

    void HandleMovement()
    {
        //if (!isMoving)
        //{
        //    Vector3 movement = Vector3.zero;

        //    if (Input.GetKeyDown(KeyCode.RightArrow))
        //        movement = Vector3.right;
        //    else if (Input.GetKeyDown(KeyCode.LeftArrow))
        //        movement = Vector3.left;
        //    else if (Input.GetKeyDown(KeyCode.UpArrow))
        //        movement = Vector3.up;
        //    else if (Input.GetKeyDown(KeyCode.DownArrow))
        //        movement = Vector3.down;

        //    if (movement != Vector3.zero)
        //    {
        //        Vector3 newPosition = targetPosition + movement * gridSize;
        //        Vector3Int newCell = tilemap.WorldToCell(newPosition);

        //        if (CanMoveToTile(newCell))
        //        {
        //            targetPosition = newPosition;
        //            isMoving = true;
        //        }
        //    }
        //}

        //if (isMoving)
        //{
        //    transform.position = Vector3.MoveTowards(transform.position, targetPosition, moveSpeed * Time.deltaTime);

        //    if (Vector3.Distance(transform.position, targetPosition) < 0.001f)
        //    {
        //        transform.position = targetPosition;
        //        isMoving = false;
        //        HandleTileAtPosition(tilemap.WorldToCell(transform.position));
        //    }
        //}
    }

    bool CanMoveToTile(Vector3Int cellPosition)
    {
        TileBase tile = tilemap.GetTile(cellPosition);
        return tile == null || tile == itemTile || tile == breakableTile;
    }

    void HandleTileAtPosition(Vector3Int cellPosition)
    {
        TileBase currentTile = tilemap.GetTile(cellPosition);

        if (currentTile == itemTile)
        {
            CollectItem(cellPosition);
        }
        else if (currentTile == breakableTile)
        {
            tilemap.SetTile(cellPosition, null);
        }
    }

    void CollectItem(Vector3Int cellPosition)
    {
        score += 100;
        UpdateScoreDisplay();
        tilemap.SetTile(cellPosition, null);
    }

    void UpdateScoreDisplay()
    {
        if (scoreText != null)
        {
            scoreText.text = $"Stage: {currentStage} Score: {score}";
        }
    }
}