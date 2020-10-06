/// <summary>
/// Class Circumference
/// </summary>
public static class Circumference
{
    /// <summary>
    /// Clamps the circumference to a [0..1] float
    /// <example>For example:
    /// <code>
    ///     float f = ZeroOneClamp(1.2f);
    /// </code>
    /// results in <c>f</c>'s having the value .2f.
    /// <code>
    ///     float f = ZeroOneClamp(-1.2f);
    /// </code>
    /// results in <c>f</c>'s having the value .8f.
    /// <code>
    ///     float f = ZeroOneClamp(1f + 1.2f);
    /// </code>
    /// results in <c>f</c>'s having the value .2f.
    /// </example>
    /// </summary>
    /// <returns>Float value in the range 0.0 and 1.0.</returns>
    public static float ZeroOneClamp(float f)
    {
        if (f % 1 > 0)
            f %= 1;
        else if (f % 1 < 0)
            f = 1 + f % 1;

        return f;
    }
}