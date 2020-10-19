using UnityEngine;

/// <summary>
/// This is a simple implementation of applying the screen's safe area to the UI.
///
/// To use it, create a Panel as child of your Canvas object,
/// configure it to cover the entire Canvas (center pivot and stretched in x and y);
/// and add UISafeArea as a component of the Panel.
///
/// If the project does not use screen rotation, set screenCanRotate to false;
/// or preferably remove/comment the Update() method
/// </summary>
public class UISafeArea : MonoBehaviour
{
    public bool screenCanRotate = true;

    private bool _isUpdateCheckActive = false;
    private ScreenOrientation _screenOrientation;
    private RectTransform _canvas;
    private float _top;
    private float _right;
    private float _bottom;
    private float _left;
    private float _screenWidth;
    private float _screenHeight;

    private void Awake()
    {
        // If the screen does not have a notch, it does nothing.
        if (Screen.height - Screen.safeArea.height == 0 &&
            Screen.width - Screen.safeArea.width == 0)
            return;

        _isUpdateCheckActive = true;

        _canvas = GetComponent<RectTransform>();

        CalculateCanvasOffsets();
    }

    // If your the project does not use screen rotation, you can comment the Update
    private void Update()
    {
        if (screenCanRotate && _isUpdateCheckActive && Screen.orientation != _screenOrientation)
        {
            CalculateCanvasOffsets();
        }
    }

    private void CalculateCanvasOffsets()
    {
        _screenOrientation = Screen.orientation;
        _top = _bottom = _left = _right = 0f;

        if (_screenOrientation == ScreenOrientation.Portrait)
        {
            _top = Screen.height - Screen.safeArea.height;
        }
        else if (_screenOrientation == ScreenOrientation.PortraitUpsideDown)
        {
            _bottom = Screen.height - Screen.safeArea.height;
        }
        else if (_screenOrientation == ScreenOrientation.LandscapeLeft)
        {
            _left = Screen.width - Screen.safeArea.width;
        }
        else if (_screenOrientation == ScreenOrientation.LandscapeRight)
        {
            _right = Screen.width - Screen.safeArea.width;
        }

        SetLimits(_top, _right, _bottom, _left);
    }

    private void SetLimits(float top, float right, float bottom, float left)
    {
        _canvas.offsetMax = new Vector2(-right, -top);
        _canvas.offsetMin = new Vector2(left, bottom);
    }
}
